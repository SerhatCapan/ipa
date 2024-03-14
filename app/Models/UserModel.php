<?php

namespace App\Models;

use CodeIgniter\Model;
use ReflectionException;

class UserModel extends Model
{
    protected $table            = 'user';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'date_from_overtime'];

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
     * TODO: needs to look on these things:
     * - Holidays
     * - Vacation
     * - Absences
     *
     * @param $user
     * @return int
     */
    public function get_overtime($user) {
        $workhourmodel = new WorkhourModel();
        $total_workhours_row = $workhourmodel
            ->select('SUM(hours) AS total_work_hours')
            ->where('id_user =', $user['id'])
            ->where('date >=', $user['date_from_overtime'])
            ->get()->getResultArray();

        if (!empty($total_workhours_row)) {
            $total_workhours = $total_workhours_row[0]['total_work_hours'];
        } else {
            $total_workhours = 0;
        }

        // return $total_workhours;
        return 0;
    }
}
