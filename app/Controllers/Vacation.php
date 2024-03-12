<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\VacationCreditModel;
use App\Models\VacationModel;
use CodeIgniter\HTTP\ResponseInterface;

class Vacation extends BaseController
{
    private $vacationmodel;
    private $vacationcreditmodel;

    public function __construct()
    {
        $this->vacationmodel = new VacationModel();
        $this->vacationcreditmodel = new VacationCreditModel();
    }

    public function index()
    {
        $data = [];
        $id_user = $this->request->getCookie('current_user_id');

        if ($id_user === null) {
            $data = [
                'vacation_credit_date_from' => null,
                'vacation_credit_date_to ' => null,
                'vacation_credit ' => null,
            ];

            return view('partials/header') .
                view('/user/vacation/index', $data) .
                view('partials/footer');
        }

        $vacation_credit = $this->vacationcreditmodel
            ->select()
            ->where('id_user', $id_user)
            ->get()->getResultArray();

        $vacation = $this->vacationmodel
            ->select()
            ->where('id_user', $id_user)
            ->get()->getResultArray();

        $table = get_table_template();
        $table->setHeading([
            'Tag',
            'Stunden'
        ]);

        foreach ($vacation as $day) {
            $table->addRow(
                '<a id="/user/vacation/' . $day['id'] . '">' . $day['date'] .  '</a>',
                $day['hours'],
                '<a id="db-icon-edit-vacation" uk-tooltip="Ferientag bearbeiten" href="vacation/edit/' .  $day['id'] . '" class="uk-icon-link uk-margin-small-right" uk-icon="pencil"></a>
                <a id="db-icon-trash-vacation" uk-tooltip="Feiertag löschen" href="vacation/delete/' . $day['id'] . '" class="uk-icon-link uk-margin-small-right" uk-icon="trash"></a>'
            );
        }

        $data = [
            'vacation_credit_date_from' => $vacation_credit[0]['date_from'],
            'vacation_credit_date_to' => $vacation_credit[0]['date_to'],
            'vacation_credit' => $vacation_credit[0]['credit'],
            'table' => $table->generate()
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
            $date_array[] = date('Y-m-d', $current_date);
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
            'message' => 'Ferientag wurde gelöscht'
        ];

        return $this->response->setJSON($return);
    }
}
