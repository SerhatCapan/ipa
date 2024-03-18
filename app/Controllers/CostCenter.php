<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CostCenterModel;
use App\Models\WorkhourModel;
use CodeIgniter\HTTP\ResponseInterface;
use ReflectionException;

class CostCenter extends BaseController
{
    private CostCenterModel $costcentermodel;
    private WorkhourModel $workhourmodel;

    public function __construct()
    {
        $this->costcentermodel = new CostCenterModel();
        $this->workhourmodel = new WorkhourModel();

    }

    /**
     * TODO:
     * - Arbeitsstunden holen
     * - Kostenstellen-Gruppe holen
     *
     * @return string
     */
    public function index() {

        $data = [
            "table" => $this->costcentermodel->get_table_html()
        ];

        return view('partials/header') .
            view('costcenter/index', $data) .
            view('partials/footer');
    }


    /**
     * Creates a costcenter.
     *
     * Requires:
     * - 'name' (name of the new costcenter)
     *
     * @return ResponseInterface
     * @throws ReflectionException
     */
    public function create(): ResponseInterface {
        $data =  [
            'name' => $this->request->getPost('name')
        ];

        $this->costcentermodel->insert($data);

        $response = [
            'success' => true,
            'message' => "Kostenstelle wurde erstellt",
            'html' => $this->costcentermodel->get_table_html(),
        ];

        return $this->response->setJSON($response);
    }


    /**
     * Calculates the amount of hours of a Costcenter.
     *
     * Requires:
     * - id
     * - date_from
     * - date_to
     *
     * @return ResponseInterface
     */
    public function read(): ResponseInterface
    {
        $id = $this->request->getPost('id');
        $id_user = $this->request->getCookie('current_user_id');
        $date_from = $this->request->getPost('date_from');
        $date_to = $this->request->getPost('date_to');
        $total_work_hours = $this->costcentermodel->get_total_workhours_of_costcenter($id, $id_user, $date_from, $date_to);

        $return = [
            'success' => true,
            'message' => "Anzahl Stunden wurden ausgerechnet",
            'total_work_hours' => $total_work_hours
        ];

        return $this->response->setJSON($return);
    }


    /**
     * Updates a costcenter.
     *
     * Requires:
     * - 'id' (id of the costcenter)
     * - 'id_costcenter_group' (id of the costcenter-group)
     * - 'name' (new name for the costcenter)
     *
     * @return ResponseInterface
     * @throws ReflectionException
     */
    public function update(): ResponseInterface
    {
        $id = $this->request->getPost('id');
        $id_costcenter_group = $this->request->getPost('id_costcenter_group');
        $name = $this->request->getPost('name');

        $this->costcentermodel
            ->set('id_costcenter_group', $id_costcenter_group)
            ->set('name', $name)
            ->update($id);

        $return = [
            'success' => true,
            'message' => 'Kostenstelle wurde aktualisiert'
        ];

        return $this->response->setJSON($return);
    }


    /**
     * Deletes the costcenter
     *
     * Requires:
     * - 'id' (id of the costcenter)
     *
     * @throws ReflectionException
     * @throws ReflectionException
     */
    public function delete(): ResponseInterface
    {
        $id = $this->request->getPost('id');
        $this->costcentermodel->delete_costcenter($id);

        $table = $this->costcentermodel->get_table_html();
        $return = [
            'success' => true,
            'message' => "Kostenstelle wurde gelöscht",
            'html' => $table
        ];

        return $this->response->setJSON($return);
    }
}
