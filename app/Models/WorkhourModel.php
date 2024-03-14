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

            if (isset($data['date_from']) && isset($data['date_to'])) {
                $where_date = "ipa_workhour.date BETWEEN '" . $data['date_from'] . "' AND '" . $data['date_to'] . "'";
                $this->where($where_date);
            };

            $this->orderBy('ipa_workhour.date', 'DESC');
            $workhours = $this->get()->getResultArray();

        $workdays = [];

        foreach ($workhours as $workhour) {
            $workdays[$workhour['date']]['workhours'][] = $workhour;

            $this
                ->select('SUM(ipa_workhour.hours) as workhours_total')
                ->where('date', $workhour['date']);

            $workdays[$workhour['date']]['workhours_total'] = $this->get()->getResultArray()[0]['workhours_total'];
        }

        return $workdays;
    }

    /**
     * Returns back the calculated sum of the time period
     *
     * @param $data array should look like this. If dates arent set, the whole time gets caluclated:
     *
     * [
     *  'date_from' => '2024-01-01",
     *  'date_to' => '2024-12-31",
     *  'id_user' => 1
     * ]
     *
     * @return int
     */
    public function get_total_workhhours($data) {

    }
}
