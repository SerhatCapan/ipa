<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CostCenterModel;
use CodeIgniter\HTTP\ResponseInterface;

class CostCenter extends BaseController
{
    private CostCenterModel $costcenter;

    public function __construct()
    {
        $this->costcenter = new CostCenterModel();
    }


    public function create()
    {
        $data =  [
            'name' => $this->request->getPost('name')
        ];

        $this->costcenter->create_costcenter($data);
    }


    public function read()
    {
        $data = [
            'id' => $this->request->getGet('id'),
            'from_date' => $this->request->getGet('from_date'),
            'to_date' => $this->request->getGet('to_date'),
        ];

        $data = $this->costcenter->read_costcenter($data);
        // return $data;
    }


    public function update($id, $data)
    {

    }


    public function delete($id)
    {

    }
}
