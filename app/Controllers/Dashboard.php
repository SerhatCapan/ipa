<?php

namespace App\Controllers;

use App\Models\CostCenterModel;
use App\Models\UserModel;
use App\Models\WorkhourModel;
use CodeIgniter\I18n\Time;
use Exception;

class Dashboard extends BaseController
{
    private WorkhourModel $workhourmodel;
    private CostCenterModel $costcentermodel;
    private $usermodel;

    public function __construct()
    {
        $this->workhourmodel = new WorkhourModel();
        $this->costcentermodel = new CostCenterModel();
        $this->usermodel = new UserModel();
    }

    /**
     * @throws Exception
     */
    public function index(): string
    {
       $user_id = $this->request->getCookie('current_user_id');

       if ($user_id === null) {
           $data = [
               'workdays' => null,
               'costcenters' => null,
               'current_user' => null
           ];

           return view('partials/header') .
               view('/dashboard/index', $data) .
               view('partials/footer');
       }

       $user = $this->usermodel->find($user_id);

       $workdays = $this->workhourmodel->get_as_workdays([
           'id_user' => $user['id']
       ]);
        
       $data = [
           'workdays' => $workdays,
           'costcenters' => $this->costcentermodel->findAll(),
           'current_user' => $user
       ];

        return view('partials/header') .
            view('/dashboard/index', $data) .
            view('partials/footer');
    }
}
