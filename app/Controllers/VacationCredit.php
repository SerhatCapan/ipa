<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\VacationCreditModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;
use ReflectionException;

class VacationCredit extends BaseController
{

    private VacationCreditModel $vacationcreditmodel;
    private UserModel $usermodel;

    public function __construct()
    {
        $this->usermodel = new UserModel();
        $this->vacationcreditmodel = new VacationCreditModel();
    }

    /**
     * Index of the vacation credit page
     *
     * @return string
     */
    public function index(): string
    {
        $id_user = $this->request->getCookie('current_user_id');

        if (!$this->usermodel->user_exist($id_user)) {
            $data = [
                'current_user' => null,
                'table' => null
            ];

            return view('partials/header') .
                view('/user/vacation-credit/index', $data) .
                view('partials/footer');
        }

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
            'current_user' => $id_user,
            'table' => $table->generate()
        ];

        return view('partials/header') .
            view('/user/vacation-credit/index', $data) .
            view('partials/footer');
    }

    /**
     * Creates a new vacation credit
     *
     * Requires:
     * - vacation-credit-date-from
     * - vacation-credit-date-to
     * - vacation-credit-credit
     *
     * @return RedirectResponse
     * @throws ReflectionException
     */
    public function create(): RedirectResponse
    {
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
}
