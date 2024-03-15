<?php

namespace App\Controllers;

use App\Models\AbsenceModel;
use App\Models\CostCenterGroupModel;
use App\Models\CostCenterModel;
use App\Models\HolidayModel;
use App\Models\OptionModel;
use App\Models\UserModel;
use App\Models\VacationModel;
use App\Models\WorkhourModel;
use CodeIgniter\I18n\Time;
use Exception;

class Dashboard extends BaseController
{
    private WorkhourModel $workhourmodel;
    private CostCenterModel $costcentermodel;
    private OptionModel $optionmodel;
    private UserModel $usermodel;
    private VacationModel $vacationmodel;
    private CostCenterGroupModel $costcentergroupmodel;

    public function __construct()
    {
        $this->workhourmodel = new WorkhourModel();
        $this->costcentermodel = new CostCenterModel();
        $this->usermodel = new UserModel();
        $this->optionmodel = new OptionModel();
        $this->vacationmodel = new VacationModel();
        $this->costcentergroupmodel = new CostCenterGroupModel();
    }

    /**
     * Prepares all the data for the dashboard site and echoes the view
     *
     * @throws Exception
     */
    public function index(): string
    {
        $id_user = $this->request->getCookie('current_user_id');
        $date_from = $this->request->getGet('date_from') ?? date('Y-m-d', strtotime('monday this week'));
        $date_to = $this->request->getGet('date_to') ?? date('Y-m-d', strtotime('friday this week'));
        $date_from_format = Time::parse($date_from, 'Europe/Zurich');
        $date_to_format = Time::parse($date_to, 'Europe/Zurich');

        // If no user is selected, don't show anything
        if ($id_user === null) {
            $data = [
                'workdays' => null,
                'costcenters' => null,
                'current_user' => null,
                'weekly_analysis' => null,
                'date_from' => $date_from_format,
                'date_to' => $date_to_format,
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
            'costcenters' => $this->costcentermodel->get_costcenters(),
            'costcentergroups' => $this->costcentergroupmodel->findAll(),
            'current_user' => $user,
            'calendar' => $calendar,
            'date_from' => $date_from_format,
            'date_to' => $date_to_format,
            'overtime' => $this->usermodel->get_overtime($user),
            'vacation_remaining_credits' => $this->vacationmodel->get_vacation($date_from)['vacation_remaining_credits'],
        ];

        return view('partials/header') .
            view('/dashboard/index', $data) .
            view('partials/footer');
    }


    private function get_calendar($selected_date_from, $selected_date_to)
    {
        $vacationmodel = new VacationModel();
        $absencemodel = new AbsenceModel();
        $holidaymodel = new HolidayModel();

        $calendar = [];
        $startday = strtotime('last Monday', strtotime($selected_date_from));

        for ($i = 0; $i < 5; $i++) {
            $week_days = [];

            $monday_of_current_week = date('Y-m-d', strtotime("+0 day", $startday));
            $friday_of_current_week = date('Y-m-d', strtotime("+4 day", $startday));

            for ($j = 0; $j < 5; $j++) {
                $date = date('Y-m-d', strtotime("+$j day", $startday));
                $type = 'workday';
                $tooltip = "";

                $models = [
                    'vacation' => $vacationmodel,
                    'absence' => $absencemodel,
                    'holiday' => $holidaymodel
                ];

                foreach ($models as $key => $model) {
                    $data = $model
                        ->select()
                        ->where('date', $date)
                        ->get()->getResultArray();

                    if (!empty($data)) {
                        $type = $key;

                        if ($key == 'vacation') {
                            $tooltip = "Ferien - " . $data[0]['hours'] . "h";

                        } elseif ($key == 'absence') {
                            $tooltip = esc($data[0]['reason']) . " - " . $data[0]['hours'] . "h";

                        } elseif ($key == 'holiday') {
                            $tooltip = esc($data[0]['name']) . " - " . $data[0]['hours'] . "h";
                        }
                    }
                }

                $week_days[] = [
                    "type" => $type,
                    "date" => $date,
                    "tooltip" => $tooltip
                ];
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
