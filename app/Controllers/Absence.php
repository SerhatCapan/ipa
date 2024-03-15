<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AbsenceModel;
use CodeIgniter\HTTP\ResponseInterface;

class Absence extends BaseController
{

    private $absence;

    public function __construct()
    {
        $this->absence = new AbsenceModel();
    }

    public function index()
    {
        $id_user = $this->request->getCookie('current_user_id');

        // If no user is selected, don't show anything
        if ($id_user === null) {
            $data = [
                'current_user' => null,
            ];

            return view('partials/header') .
                view('/dashboard/index', $data) .
                view('partials/footer');
        }

        $data = [
            'current_user' => $id_user,
            'table' => $this->absence->get_table_html($id_user)
        ];

        return view('partials/header') .
            view('user/absence/index', $data) .
            view('partials/footer');
    }


    /**
     * Creates an absence
     *
     * Requires:
     * - absence-date
     * - absence-reason
     *
     * @throws \ReflectionException
     */
    public function create() {
        $id_user = $this->request->getCookie('current_user_id');
        $date = $this->request->getPost('absence-date');
        $reason = $this->request->getPost('absence-reason');
        $hours = $this->request->getPost('absence-hours');

        $absence_exist = $this->absence
            ->select()
            ->where('date', $date)
            ->where('id_user', $id_user)
            ->get()->getResultArray();

        if (!empty($absence_exist)) {
            $flashdata = [
                'return' => [
                    'success' => false,
                    'message' => 'Absenz konnte nicht erstellt werden da eine Absenz am gleichen Tag schon existiert'
                ]
            ];

            $session = session();
            $session->setFlashdata($flashdata);
            return redirect()->to('user/absence');
        }

        $data = [
            'id_user' => $id_user,
            'date' => $date,
            'reason' => $reason,
            'hours' => $hours
        ];

        $this->absence->insert($data);

        $flashdata = [
            'return' => [
                'success' => true,
                'message' => 'Absenzen wurden erstellt'
            ]
        ];

        $session = session();
        $session->setFlashdata($flashdata);
        return redirect()->to('user/absence');
    }


    /**
     * Updates the absence
     *
     * Requires:
     * - id
     * - absence-date
     * - hours
     *
     * @return ResponseInterface
     * @throws \ReflectionException
     */
    public function update(): ResponseInterface {
        $id = $this->request->getPost('id');
        $id_user = $this->request->getCookie('current_user_id');
        $reason = $this->request->getPost('reason');

        $this->absence
            ->set('reason', $reason)
            ->update($id);

        $return = [
            'success' => true,
            'message' => 'Absenz wurde aktualisiert',
         ];

        return $this->response->setJSON($return);
    }

    /**
     * Deletes the Absence.
     *
     * Requires:
     * - id
     *
     * @return ResponseInterface
     */
    public function delete(): ResponseInterface {
        $id_user = $this->request->getCookie('current_user_id');
        $id = $this->request->getPost('id');
        $this->absence->delete($id);

        $return = [
            'success' => true,
            'message' => 'Absenz wurde gelöscht',
            'html' => $this->absence->get_table_html($id_user)
        ];

        return $this->response->setJSON($return);
    }
}
