<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\HolidayModel;
use CodeIgniter\HTTP\ResponseInterface;

class Holiday extends BaseController
{
    private $holidaymodel;

    public function __construct()
    {
        $this->holidaymodel = new HolidayModel();
    }

    public function index()
    {
        $data = [
            'table' => $this->holidaymodel->get_table_html()
        ];

        return view('partials/header.php') .
            view('holiday/index', $data) .
            view('partials/footer');

        //
    }

    public function create()
    {
        $date = $this->request->getPost('holiday-date');
        $hours = $this->request->getPost('holiday-hours');
        $name = $this->request->getPost('holiday-name');
        $session = session();

        $holiday_exist = $this->holidaymodel->select()->where('date', $date)->get()->getResultArray();

        if (!empty($holiday_exist)) {
            $flashdata = [
                'return' => [
                    'success' => false,
                    'message' => 'Feiertag konnte nicht erstellt da bereits ein Feiertag am gleichen Tag existiert'
                ]
            ];

            $session->setFlashdata($flashdata);
            return redirect()->to('/holiday');
        }

        $data = [
            'date' => $date,
            'hours' => $hours,
            'name' => $name,
        ];

        $this->holidaymodel->insert($data);

        $flashdata = [
            'return' => [
                'success' => true,
                'message' => 'Feiertag wurde erstellt'
            ]
        ];

        $session->setFlashdata($flashdata);
        return redirect()->to('/holiday');
    }
}
