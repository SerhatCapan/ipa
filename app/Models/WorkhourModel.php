<?php

namespace App\Models;

use CodeIgniter\Model;

class WorkhourModel extends Model
{
    protected $table            = 'workhour';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_user', 'id_costcenter', 'date', 'hours', 'description'];

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

    public function get_as_workdays($data) {
        $this
            ->select('ipa_workhour.id, ipa_workhour.hours, ipa_workhour.date, ipa_costcenter.description, ipa_costcenter.id AS id_costcenter , ipa_costcenter.name')
            ->join('ipa_costcenter', 'ipa_costcenter.id = ipa_workhour.id_costcenter', 'left');

            if (isset($data['id_user'])) {
                $this->where('id_user', $data['id_user']);
            };

            if (isset($data['date'])) {
                $this->where('date', $data['date']);
            };

            if (isset($data['id'])) {
                $this->where('ipa_workhour.id', $data['id']);
            };


        $workhours = $this->orderBy('ipa_workhour.date', 'DESC')
            ->get()->getResultArray();

        $workdays = [];

        foreach ($workhours as $workhour) {
            $workdays[$workhour['date']]['workhours'][] = $workhour;
            $workdays[$workhour['date']]['workhours_total'] =
                $this
                    ->select('SUM(ipa_workhour.hours) as workhours_total')
                    ->where('date', $workhour['date'])
                    ->get()->getResultArray()[0]['workhours_total'];
        }

        return $workdays;
    }
}
