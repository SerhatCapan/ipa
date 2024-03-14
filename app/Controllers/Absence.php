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
            'current_user' => $id_user
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
     * @return ResponseInterface
     * @throws \ReflectionException
     */
    public function create(): ResponseInterface {
        $id_user = $this->request->getCookie('current_user_id');
        $date = $this->request->getCookie('absence-date');
        $reason = $this->request->getCookie('absence-reason');

        $absence_exist = $this->absence
            ->select()
            ->where('date', $date)
            ->where('id_user', $id_user)
            ->get()->getResultArray();

        if (!empty($absence_exist)) {
            $return = [
                'success' => false,
                'message' => 'Absenz konnte nicht erstellt werden da eine Absenz am gleichen Tag schon existiert'
            ];

            return $this->response->setJSON($return);
        }

        $data = [
            'id_user' => $id_user,
            'date' => $date,
            'reason' => $reason
        ];

        $this->absence->insert($data);

        $return = [
            'success' => true,
            'message' => 'Absenz wurde erstellt',
            'html' => $this->absence->get_table_html($id_user)
        ];

        return $this->response->setJSON($return);
    }


    /**
     * Updates the absence
     *
     * Requires:
     * - id
     * - absence-date
     *
     * @return ResponseInterface
     * @throws \ReflectionException
     */
    public function update(): ResponseInterface {
        $id = $this->request->getPost('id');
        $reason = $this->request->getPost('reason');

        $this->absence->set('reason', $reason)->update($id);

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
