<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CostCenterModel;
use CodeIgniter\HTTP\ResponseInterface;
use ReflectionException;

class CostCenter extends BaseController
{
    private CostCenterModel $costcenter;

    public function __construct()
    {
        $this->costcenter = new CostCenterModel();
    }

    public function index() {
        $table = get_table_template();

        $table->setHeading('Name', 'Kostenstellen-Gruppe', 'Arbeitsstunden', '');

        


        $data = [
            "costcenters" => $this->costcenter->findAll(),
            "table" =>
        ];


        return view('partials/header') .
            view('costcenter/index', $data) .
            view('partials/footer');
    }

    /**
     * @throws ReflectionException
     */
    public function create(): ResponseInterface {
        $data =  [
            'name' => $this->request->getPost('name')
        ];

        $this->costcenter->insert($data);

        $response = [
            'success' => true,
            'costcenter' => $this->costcenter->find($this->costcenter->getInsertID()),
            'message' => "Kostenstelle wurde erstellt"
        ];

        return $this->response->setJSON($response);
    }


    public function read()
    {
        $data = [
            'id' => $this->request->getGet('id'),
            'from_date' => $this->request->getGet('from_date'),
            'to_date' => $this->request->getGet('to_date'),
        ];

        $data = $this->costcenter->find($data);
    }


    public function update($id, $data)
    {

    }


    public function delete($id)
    {

    }
}
