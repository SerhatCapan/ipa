<?php

namespace App\Models;

use App\Controllers\CostCenter;
use CodeIgniter\Model;

class CostCenterGroupModel extends Model
{
    protected $table            = 'costcenter_group';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'delete'];

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


    /**
     * Gets the table HTML
     *
     * @return string
     */
    public function get_table_html(): string
    {
        $table = get_table_template();
        $table->setHeading('Name', '');
        $costcentermodel = new CostCenterModel();
        $costcenter_groups = $this->findAll();

        foreach ($costcenter_groups as $costcenter_group) {
            if ($costcenter_group['delete'] == 1) {
                $table->addRow(
                    '<span class="uk-text-muted db-input-update-costcenter-group-name" data-id-costcenter-group="' . $costcenter_group['id'] .  '">' . esc($costcenter_group['name']) . '</span>'
                );
            } else {
                $table->addRow(
                    '<span contenteditable class="db-input-update-costcenter-group-name" data-id-costcenter-group="' . $costcenter_group['id'] .  '">' . esc($costcenter_group['name']) . '</span>',
                    '<a uk-tooltip="Kostenstellen-Gruppe löschen" class="db-icon-delete-costcenter-group uk-icon-link uk-margin-small-right" data-id-costcenter-group="' . $costcenter_group['id'] .  '" uk-icon="trash"></a>'
                );
            }
        }

        return $table->generate();
    }
}
