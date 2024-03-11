<?php

namespace App\Controllers;

use App\Models\CostCenterModel;
use App\Models\WorkhourModel;
use CodeIgniter\I18n\Time;
use Exception;

class Dashboard extends BaseController
{
    private WorkhourModel $workhourmodel;
    private CostCenterModel $costcentermodel;
    private $session;

    public function __construct()
    {
        $this->workhourmodel = new WorkhourModel();
        $this->costcentermodel = new CostCenterModel();
        $this->session = session();
    }

    /**
     * @throws Exception
     */
    public function index(): string
    {
       $data = [
           'id_user' => $this->session->get('current_user')['id']
       ];

       $workdays = $this->workhourmodel->get_as_workdays($data);
        
       $data = [
           'workdays' => $workdays,
           'costcenters' => $this->costcentermodel->findAll()
       ];

        return view('partials/header') .
            view('/dashboard/index', $data) .
            view('partials/footer');
    }
}
