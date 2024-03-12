<?php

namespace App\Controllers;

use App\Models\CostCenterModel;
use App\Models\OptionModel;
use App\Models\UserModel;
use App\Models\WorkhourModel;
use CodeIgniter\I18n\Time;
use Exception;

class Dashboard extends BaseController
{
    private WorkhourModel $workhourmodel;
    private CostCenterModel $costcentermodel;
    private OptionModel $optionmodel;
    private UserModel $usermodel;

    public function __construct()
    {
        $this->workhourmodel = new WorkhourModel();
        $this->costcentermodel = new CostCenterModel();
        $this->usermodel = new UserModel();
        $this->optionmodel = new OptionModel();
    }

    /**
     * @throws Exception
     */
    public function index(): string
    {
        $id_user = $this->request->getCookie('current_user_id');
        $date_from = $this->request->getGet('date_from') ?? date('Y-m-d', strtotime('monday this week'));
        $date_to = $this->request->getGet('date_to') ?? date('Y-m-d', strtotime('friday this week'));
        $date_from_format = Time::parse($date_from, 'Europe/Zurich');
        $date_to_format = Time::parse($date_to, 'Europe/Zurich');
        $calendar_time_period = $date_from_format->toLocalizedString('dd. MMM yyyy') . ' - ' . $date_to_format->toLocalizedString('dd. MMM yyyy');

        if ($id_user === null) {
            $data = [
                'workdays' => null,
                'costcenters' => null,
                'current_user' => null,
                'weekly_analysis' => null,
                'calendar_time_period' => $calendar_time_period
            ];

            return view('partials/header') .
                view('/dashboard/index', $data) .
                view('partials/footer');
        }


        $user = $this->usermodel->find($id_user);
        $data_workdays['id_user'] = $user['id'];
        $data_workdays['date_from'] = $date_from;
        $data_workdays['date_to'] = $date_to;

        $calendar = $this->get_calendar($date_from, $date_to);

        $workdays = $this->workhourmodel->get_as_workdays($data_workdays);

        $data = [
            'workdays' => $workdays,
            'costcenters' => $this->costcentermodel->findAll(),
            'current_user' => $user,
            'calendar' => $calendar,
            'calendar_time_period' => $calendar_time_period,
            'weekly_analysis' => [
                'total_workhours' => $this->workhourmodel->get_total_workhhours([
                    'id_user' => $id_user,
                    'date_from' => $date_from,
                    'date_to' => $date_to,
                ]),

                'should_workhours' => $this->optionmodel->get_workhours_per_day() * 5 // TODO: Won't work if Absence, Feast Day or Holiday was taken
            ]
        ];

        return view('partials/header') .
            view('/dashboard/index', $data) .
            view('partials/footer');
    }


    private function get_calendar($selected_date_from, $selected_date_to)
    {
        $calendar = [];
        $startday = strtotime('last Monday', strtotime($selected_date_from));

        for ($i = 0; $i < 5; $i++) {
            $week_days = [];

            $monday_of_current_week = date('Y-m-d', strtotime("+0 day", $startday));
            $friday_of_current_week = date('Y-m-d', strtotime("+4 day", $startday));

            for ($j = 0; $j < 5; $j++) {
                $week_days[] = date('Y-m-d', strtotime("+$j day", $startday));
            }

            if ($monday_of_current_week === $selected_date_from && $friday_of_current_week === $selected_date_to) {
                $active_week = true;
            } else {
                $active_week = false;
            }

            $calendar['weeks'][] = [
                'weekdays' => $week_days,
                'active_week' => $active_week
            ];

            $startday = strtotime('+1 week', $startday);
        }

        $calendar['heading'] = ['Mo', 'Di', 'Mi', 'Do', 'Fr'];

        return $calendar;
    }
}
