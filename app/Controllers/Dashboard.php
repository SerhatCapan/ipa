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
       $data = [
           'workdays' => $this->get_workdays()
       ];

        return view('partials/header') .
            view('/dashboard/index', $data) .
            view('partials/footer');
    }

    public function get_rendered_card() {
        $workdays = $this->get_workdays();

        $html = '';

        foreach ($workdays as $date => $workday) {
            $html .= render_dashboard_card([]);
        }
    }

    private function get_workdays() {
        $workhours = $this->workhourmodel
            ->select('ipa_workhour.id, ipa_workhour.hours, ipa_workhour.date, ipa_costcenter.description, ipa_costcenter.id_costcenter_group, ipa_costcenter.name')
            ->join('ipa_costcenter', 'ipa_costcenter.id = ipa_workhour.id_costcenter', 'left')
            ->orderBy('ipa_workhour.date', 'DESC')
            ->get()->getResultArray();

        $workdays = [];

        foreach ($workhours as $workhour) {
            $workdays[$workhour['date']]['workhours'][] = $workhour;
            $workdays[$workhour['date']]['workhours_total'] =
                $this->workhourmodel
                    ->select('SUM(ipa_workhour.hours) as workhours_total')
                    ->where('date', $workhour['date'])
                    ->get()->getResultArray()[0]['workhours_total'];
        }

        return $workdays;
    }
}
