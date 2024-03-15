<?php

namespace App\Models;

use CodeIgniter\Model;

class AbsenceModel extends Model
{
    protected $table            = 'absence';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_user', 'date', 'reason', 'hours'];

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

    public function get_table_html($id_user)
    {
        $absences = $this->select()->where('id_user', $id_user)->get()->getResultArray();
        $table = get_table_template();
        $table->setHeading([
            'Datum',
            'Grund',
            'Stunden',
            ''
        ]);

        foreach ($absences as $absence) {
            $table->addRow(
                $absence['date'],
                '<span data-id-absence="' . $absence['id'] .  '" class="db-input-update-absence-name" contenteditable>' . esc($absence['reason']) . '</span>',
                '<span>' . $absence['hours'] . '</span>',
                '<a uk-tooltip="Absenz löschen" class="db-icon-delete-absence uk-icon-link uk-margin-small-right" data-id-absence="' . $absence['id'] .  '" uk-icon="trash"></a>'
            );
        }

        return $table->generate();
    }
}
