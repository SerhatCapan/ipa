<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\WorkhourModel;
use CodeIgniter\HTTP\ResponseInterface;
use ReflectionException;

class Workhour extends BaseController
{
    private WorkhourModel $workhourmodel;
    private $session;

    public function __construct()
    {
        $this->workhourmodel = new WorkhourModel();
        $this->session = session();
    }

    /**
     * @throws ReflectionException
     */
    public function create()
    {
        $date = $this->request->getPost('date');
        $user = $this->session->get('current_user');
        $this->workhourmodel->insert([
            'id_user' => $user['id'],
            'date' => $date
        ]);

        $workhour = $this->workhourmodel->find($this->workhourmodel->getInsertID());
        $return = [
            'success' => true,
            'message' => 'Neue Arbeitsstunde wurde erstellt',
            'html' => get_html_dashboard_card_row(['workhour' => $workhour, 'date' => $date])
        ];

        return $this->response->setJSON($return);
    }

    public function read($id)
    {

    }

    /**
     * @throws ReflectionException
     */
    public function update()
    {
        $id = $this->request->getPost('id');
        $hours = $this->request->getPost('hours');

        $this->workhourmodel
            ->set('hours', $hours)
            ->where('id', $id)
            ->update();
    }

    public function delete()
    {
        $id = $this->request->getPost('id');
        $this->workhourmodel->delete($id);

        $return = [
            'success' => true,
            'message' => 'Arbeitsstunde wurde gelöscht',
        ];

        return $return;
    }
}
