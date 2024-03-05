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
    protected $allowedFields    = ['name'];

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
     * @throws ReflectionException
     */
    public function create_costcenter(array $data) {
        $this->insert($data);
    }

    public function read_costcenter($data) {


        $result = $this->select('*')->get()->getResult;



        return $result;
    }

    public function delete_costcenter($id) {
        $this->delete($id);
    }
}
