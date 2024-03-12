<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CostCenterModel;
use App\Models\UserModel;
use App\Models\WorkhourModel;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;
use ReflectionException;

class Workday extends BaseController
{
    private $workhourmodel;
    private $costcentermodel;
    private UserModel $usermodel;

    public function __construct()
    {
        $this->workhourmodel = new WorkhourModel();
        $this->costcentermodel = new CostCenterModel();
        $this->usermodel = new UserModel();
    }

    /**
     * @throws ReflectionException
     * @throws Exception
     */
    public function create()
    {
        $user_id = $this->request->getCookie('current_user_id');
        $user = $this->usermodel->find($user_id);
        $date = $this->request->getPost('date');

        $workhour = $this->workhourmodel
            ->where('date', $date)
            ->where('id_user', $user['id'])
            ->first();

        if ($workhour !== null) {
            $return = [
                'success' => false,
                'message' => 'Arbeitstag existiert schon',
            ];

            return $this->response->setJSON($return);
        }


        $data = [
            'id_user' => $user['id'],
            'date' => $date
        ];

        $this->workhourmodel->insert($data);
        $workday = $this->workhourmodel->get_as_workdays($data);
        $costcenters = $this->costcentermodel->findAll();

        $workday_html = get_html_dashboard_card(['workday' => $workday[$date], 'date' => $date, 'costcenters' => $costcenters]);

        $return = [
            'success' => true,
            'message' => 'Arbeitstag wurde erstellt',
            'html' => $workday_html
        ];

        return $this->response->setJSON($return);
    }

    public function read() {

    }

    public function delete()
    {

    }
}
