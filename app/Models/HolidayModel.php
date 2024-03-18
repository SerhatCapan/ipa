<?php

namespace App\Models;

use CodeIgniter\Model;

class HolidayModel extends Model
{
    protected $table            = 'holiday';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['date', 'hours', 'name'];

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
     * Gets holiday table
     *
     * @return string
     */
    public function get_table_html(): string {
        $table = get_table_template();
        $table->setHeading(
            'Datum',
            'Name',
            'Stunden',
            ''
        );

        $holidays = $this->findAll();

        foreach ($holidays as $holiday) {
            $table->addRow(
                $holiday['date'],
                esc($holiday['name']),
                $holiday['hours'],
                '<a uk-tooltip="Feiertag löschen" class="db-icon-delete-holiday uk-icon-link uk-margin-small-right" data-id-holiday="' . $holiday['id'] .  '" uk-icon="trash"></a>'

            );
        }

        return $table->generate();
    }
}
