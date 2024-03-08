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

    public function __construct()
    {
        $this->workhourmodel = new WorkhourModel();
        $this->costcentermodel = new CostCenterModel();
    }

    /**
     * @throws Exception
     */
    public function index(): string
    {

       $costcenters = $this->costcentermodel
            ->select('*')
            ->join('ipa_workhour', 'ipa_costcenter.id = ipa_workhour.id_costcenter', 'left')
            ->get()->getResultArray();

       $table = get_table_template();

       foreach ($costcenters as $costcenter) {
           $table->addRow($costcenter['name'], $costcenter['hours']);
           $table->addRow($costcenter['name'], $costcenter['hours']);
       }

       $data = [
           'table' => $table->generate()
       ];

        return view('partials/header') .
            view('/dashboard/index', $data) .
            view('partials/footer');
    }

    public function get_card_date() {

    }
}
