<?php

namespace App\Models;

use CodeIgniter\Model;

class VacationCreditModel extends Model
{
    protected $table            = 'vacation_credit';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_user', 'date_from', 'date_to', 'credit'];

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
     * Gets the vacation credit of the given date.
     *
     * @param string $date
     */
    function get_vacation_credit_from_date(string $date) {
        $vacation_credit = $this
            ->select()
            ->where('date_from <=', $date)
            ->where('date_to >=', $date)
            ->get()->getResultArray();

        return $vacation_credit[0] ?? [];
    }
}
