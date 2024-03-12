<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\OptionModel;
use CodeIgniter\HTTP\ResponseInterface;

class Settings extends BaseController
{

    private OptionModel $optionmodel;

    public function __construct()
    {
        $this->optionmodel = new OptionModel();
    }

    public function index()
    {

        $workhours_per_day = $this->optionmodel
            ->select()
            ->where('name', 'workhours_per_day')
            ->get()->getResultArray()[0]['value'];

        $data = [
          'workhours_per_day' => $workhours_per_day
        ];

        return view('partials/header') .
            view('/settings/index', $data) .
            view('partials/footer');
    }

    public function update() {
        $workhours_per_day = $this->request->getPost('option-workhours-per-day');

        $this->optionmodel
            ->set('value', $workhours_per_day)
            ->where('name =', 'workhours_per_day')
            ->update();

        $flashdata = [
            'return' => [
                'success' => true,
                'message' => 'Arbeitsstunden wurden aktualisiert'
            ]
        ];

        $session = session();
        $session->setFlashdata($flashdata);
        return redirect()->to('settings');
    }
}
