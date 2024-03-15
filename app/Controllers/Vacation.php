<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\VacationCreditModel;
use App\Models\VacationModel;
use CodeIgniter\HTTP\ResponseInterface;

class Vacation extends BaseController
{
    private $vacationmodel;
    private $vacationcreditmodel;
    private $usermodel;

    public function __construct()
    {
        $this->vacationmodel = new VacationModel();
        $this->vacationcreditmodel = new VacationCreditModel();
        $this->usermodel = new UserModel();
    }

    public function index()
    {
        $id_user = $this->request->getCookie('current_user_id');

        if (!$this->usermodel->user_exist($id_user)) {
            $data = [
                'current_user' => null,
                'vacation_credit_date_from' => null,
                'vacation_credit_date_to ' => null,
                'vacation_credit ' => null,
            ];

            return view('partials/header') .
                view('/user/vacation/index', $data) .
                view('partials/footer');
        }

        $table = $this->vacationmodel->get_table_html();
        $vacation = $this->vacationmodel->get_vacation(date('Y-m-d', strtotime('now')));

        $data = [
            'current_user' => $id_user,
            'vacation_credit_date_from' => $vacation['vacation_credit']['date_from'],
            'vacation_credit_date_to' => $vacation['vacation_credit']['date_to'],
            'vacation_credit' => $vacation['vacation_credit']['credit'],
            'vacation_remaining_credits' => $vacation['vacation_remaining_credits'],
            'table' => $table
        ];

        return view('partials/header') .
            view('/user/vacation/index.php', $data) .
            view('partials/footer');
    }

    public function create() {
        $date_from = $this->request->getPost('vacation-date-from');
        $date_to = $this->request->getPost('vacation-date-to');
        $id_user = $this->request->getCookie('current_user_id');

        $current_date = strtotime($date_from);
        $end_timestamp = strtotime($date_to);

        while ($current_date <= $end_timestamp) {
            // Check if current day is not Saturday (6) or Sunday (0)
            if (date('N', $current_date) < 6) {
                $date_array[] = date('Y-m-d', $current_date);
            }
            $current_date = strtotime('+1 day', $current_date);
        }

        foreach ($date_array as $day) {
            $data_insert = [
                'id_user' => $id_user,
                'date' => $day,
                'hours' => 8
            ];

            $this->vacationmodel->insert($data_insert);
        }

        $flashdata = [
            'return' => [
                'success' => true,
                'message' => 'Ferien wurden erstellt'
            ]
        ];

        $session = session();
        $session->setFlashdata($flashdata);
        return redirect()->to('user/vacation');
    }


    public function delete() {
        $id = $this->request->getPost('id');
        $this->vacationmodel->delete($id);

        $return = [
            'success' => true,
            'message' => 'Ferientag wurde gelöscht',
            'html' =>  $this->vacationmodel->get_table_html()
        ];

        return $this->response->setJSON($return);
    }
}
