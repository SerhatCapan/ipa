<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CostCenterGroupModel;
use App\Models\CostCenterModel;
use CodeIgniter\HTTP\ResponseInterface;
use ReflectionException;

class CostCenterGroup extends BaseController
{
    private CostCenterGroupModel $costcentergroupmodel;
    private CostCenterModel $costcentermodel;

    public function __construct()
    {
        $this->costcentergroupmodel = new CostCenterGroupModel();
        $this->costcentermodel = new CostCenterModel();
    }

    /**
     * Index of the costcenter group page
     *
     * @return string
     */
    public function index(): string
    {

        $data = [
            "table" => $this->costcentergroupmodel->get_table_html()
        ];

        return view('partials/header') .
            view('costcenter-group/index', $data) .
            view('partials/footer');
    }

    /**
     * Creates a new costcenter group
     *
     * Requires:
     * - name
     *
     * @return ResponseInterface
     * @throws ReflectionException
     */
    public function create(): ResponseInterface
    {
        $name = $this->request->getPost('name');
        $existing_row = $this->costcentergroupmodel->where('name', $name)->first();

        if ($existing_row !== null) {
            return $this->response->setJSON([
                'success' => false,
                'message' => "Es existiert bereits eine Kostenstellen-Gruppe mit dem Namen.",
                'html' => $this->costcentergroupmodel->get_table_html()
            ]);
        }

        $this->costcentergroupmodel->insert([
            'name' => $this->request->getPost('name')
        ]);

        $return = [
            'success' => true,
            'message' => "Kostenstelle-Gruppe wurde erstellt",
            'html' => $this->costcentergroupmodel->get_table_html()
        ];

        return $this->response->setJSON($return);
    }

    /**
     * Calculates the amount of hours of a Costcenter-Group.
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
        $total_work_hours = 0;

        $costcenters = $this->costcentermodel
            ->select()
            ->where('id_costcenter_group =', $id)
            ->get()->getResultArray();

        if (!empty($costcenters)) {
            foreach ($costcenters as $costcenter) {
                $total_work_hours += $this->costcentermodel->get_total_workhours_of_costcenter($costcenter['id'], $id_user, $date_from, $date_to);
            }
        }

        $return = [
            'success' => true,
            'message' => "Anzahl Stunden wurden ausgerechnet",
            'total_work_hours' => $total_work_hours
        ];

        return $this->response->setJSON($return);
    }

    /**
     * Deletes costcentergroup
     *
     * Required:
     * - id (id of the costcentergroup)
     *
     * @return ResponseInterface
     * @throws ReflectionException
     */
    public function delete(): ResponseInterface
    {
        $id = $this->request->getPost('id');
        $costcentermodel = new CostCenterModel();

        $costcenters = $this->costcentermodel
            ->select()
            ->where('id_costcenter_group =', $id)
            ->get()->getResultArray();


        // delete each costcenter
        foreach ($costcenters as $costcenter) {
            $costcentermodel->delete_costcenter($costcenter['id']);
        }

        $costcenters = $this->costcentermodel
            ->select()
            ->where('id_costcenter_group =', $id)
            ->get()->getResultArray();


        // check if costcenter-group has any costcenters left. If not delete completely.
        if (empty($costcenters)) {
            $this->costcentergroupmodel->delete($id);

        } else {
            $this->costcentergroupmodel
                ->set('delete', 1)
                ->update($id);
        }

        $return = [
            'success' => true,
            'message' => "Kostenstellen-Gruppe wurde gelöscht",
            'html' => $this->costcentergroupmodel->get_table_html(),
        ];

        return $this->response->setJSON($return);
    }
}
