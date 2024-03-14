<?php

namespace App\Models;

use CodeIgniter\Model;
use ReflectionException;

class CostCenterModel extends Model
{
    protected $table            = 'costcenter';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'delete', 'id_costcenter_group', 'description'];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function get_total_workhours_of_costcenter(int $id_costcenter, int $id_user, string $date_from = null, string $date_to = null) {
        $costcenter = new CostCenterModel();
        $costcenter
            ->select('SUM(ipa_workhour.hours) AS total_work_hours')
            ->join('ipa_workhour', 'ipa_costcenter.id = ipa_workhour.id_costcenter', 'left')
            ->where('ipa_costcenter.id', $id_costcenter)
            ->where('ipa_workhour.id_user', $id_user);

            if ($date_from !== null && $date_to !== null) {
                $costcenter->where("ipa_workhour.date BETWEEN '" . $date_from . "' AND '" . $date_to . "'");
            }

            $total_work_hours = $costcenter->get()->getResultArray();

        $query = $costcenter->getLastQuery();

        if (!empty($total_work_hours[0]['total_work_hours'])) {
            return $total_work_hours[0]['total_work_hours'];
        } else {
            return 0;
        }
    }

    public function get_table_html() {
        $costcentergroupmodel = new CostCenterGroupModel();
        $table = get_table_template();
        $table->setHeading('Name', 'Kostenstellen-Gruppe', '');

        $costcenters = $this
            ->select('ipa_costcenter.id, ipa_costcenter.name, ipa_costcenter_group.name AS costcenter_group_name, ipa_costcenter.delete, ipa_costcenter.id_costcenter_group')
            ->join('ipa_costcenter_group', 'ipa_costcenter.id_costcenter_group = ipa_costcenter_group.id', 'left')
            ->get()->getResultArray();

        $costcenter_groups = $costcentergroupmodel
            ->select()
            ->where('delete !=', 1)
            ->get()->getResultArray();

        foreach ($costcenters as $costcenter) {
            if ($costcenter['delete'] == 1) {
                $table->addRow(
                    esc($costcenter['name']),
                    esc($costcenter['costcenter_group_name']),
                );

            } else {
                // There are also costcenters without costcenter-groups
                $select_options = '<option value="null">Keine</option>';

                // creates the select html
                foreach ($costcenter_groups as $costcenter_group) {
                    $selected =  $costcenter['id_costcenter_group'] === $costcenter_group['id'] ? "selected" : "";
                    $select_options .= '<option ' . $selected . ' value="' . $costcenter_group['id'] . '">' . esc($costcenter_group['name']) . '</option>';
                }

                $table->addRow(
                    '<span class="db-input-update-costcenter-name" data-id-costcenter="' . $costcenter['id'] .  '" contenteditable>' . esc($costcenter['name']) . '</span>',
                    '<select class="db-select-update-costcenter uk-select" data-id-costcenter="' . $costcenter['id'] .  '" aria-label="Select">' . $select_options . '</select>',
                    '<a data-id-costcenter="' . $costcenter['id'] .  '" uk-tooltip="Kostenstelle löschen" class="db-icon-delete-costcenter uk-icon-link uk-margin-small-right" uk-icon="trash"></a>'
                );
            }
        }

        return $table->generate();
    }


    /**
     * Soft deletes if costcenter has workhours so that they don't get lost. Delete completely if not.
     *
     * @param $id
     * @return void
     */
    public function delete_costcenter($id) {
        $workhourmodel = new WorkhourModel();
        $workhours = $workhourmodel
            ->select()
            ->where('id_costcenter', $id)
            ->get()->getResultArray();

        // delete completely if no workhours are set
        if (empty($workhours)) {
            $this->delete($id);

        // soft-delete if workhours are set
        } else {
            $this->set('delete', 1) ->update($id);
        }
    }
}
