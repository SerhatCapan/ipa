<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\VacationCreditModel;
use CodeIgniter\HTTP\ResponseInterface;

class VacationCredit extends BaseController
{

    private  VacationCreditModel $vacationcreditmodel;

    public function __construct()
    {
        $this->vacationcreditmodel = new VacationCreditModel();
    }

    public function index()
    {

        $id_user = $this->request->getCookie('current_user_id');

        $table = get_table_template();
        $table->setHeading([
            'Von',
            'Bis',
            'Anzahl Guthaben',
        ]);

        $vacationcredits = $this->vacationcreditmodel->select()->get()->getResultArray();

        foreach ($vacationcredits as $vacationcredit) {
            $table->addRow($vacationcredit['date_from'], $vacationcredit['date_to'], $vacationcredit['credit']);
        }

        $data = [
            'table' => $table->generate()
        ];

        return view('partials/header') .
            view('/user/vacation-credit/index', $data) .
            view('partials/footer');
    }

    public function create() {
        $id_user = $this->request->getCookie('current_user_id');

        if ($id_user === null) {
            return redirect()->to('/user/vacation-credit');
        }

        $date_from = $this->request->getPost('vacation-credit-date-from');
        $date_to = $this->request->getPost('vacation-credit-date-to');
        $credit = $this->request->getPost('vacation-credit-credit');

        $data_to_insert = [
            'id_user' => $id_user,
            'date_from' => $date_from,
            'date_to' => $date_to,
            'credit' => $credit,
        ];

        $this->vacationcreditmodel->insert($data_to_insert);

        $flashdata = [
            'return' => [
                'success' => true,
                'message' => 'Ferienguthaben wurden erstellt'
            ]
        ];

        $session = session();
        $session->setFlashdata($flashdata);
        return redirect()->to('/user/vacation-credit');
    }

    public function read() {

    }

    public function update() {

    }

    public function delete() {

    }
}
