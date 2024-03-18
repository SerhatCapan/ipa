<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\HolidayModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;
use ReflectionException;

class Holiday extends BaseController
{
    private HolidayModel $holidaymodel;

    public function __construct()
    {
        $this->holidaymodel = new HolidayModel();
    }

    /**
     * Index of the holiday page
     *
     * @return string
     */
    public function index(): string
    {
        $data = [
            'table' => $this->holidaymodel->get_table_html()
        ];

        return view('partials/header.php') .
            view('holiday/index', $data) .
            view('partials/footer');

        //
    }

    /**
     * Creates a new holiday
     *
     * Requires:
     * - holiday-date
     * - holiday-hours
     * - holiday-name
     *
     * @return RedirectResponse
     * @throws ReflectionException
     */
    public function create(): RedirectResponse
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

    /**
     * Deletes a holiday
     *
     * Requires:
     * - id
     *
     * @return ResponseInterface
     */
    public function delete(): ResponseInterface
    {
        $id = $this->request->getPost('id');
        $this->holidaymodel->delete($id);

        $return = [
            'success' => true,
            'message' => 'Feiertag wurde gelöscht',
            'html' => $this->holidaymodel->get_table_html()
        ];

        return $this->response->setJSON($return);
    }
}
