<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CostCenterModel;
use App\Models\UserModel;
use App\Models\WorkhourModel;
use CodeIgniter\HTTP\ResponseInterface;
use ReflectionException;

class Workhour extends BaseController
{
    private WorkhourModel $workhourmodel;
    private CostCenterModel $costcentermodel;
    private $usermodel;

    public function __construct()
    {
        $this->workhourmodel = new WorkhourModel();
        $this->costcentermodel = new CostCenterModel();
        $this->usermodel = new UserModel();
    }

    /**
     * @throws ReflectionException
     */
    public function create()
    {
        $date = $this->request->getPost('date');
        $user_id = $this->request->getCookie('current_user_id');
        $user = $this->usermodel->find($user_id);

        $this->workhourmodel->insert([
            'id_user' => $user['id'],
            'date' => $date
        ]);

        $workhour = $this->workhourmodel->find($this->workhourmodel->getInsertID());
        $costcenters = $this->costcentermodel->findAll();

        $return = [
            'success' => true,
            'message' => 'Neue Arbeitsstunde wurde erstellt',
            'html' => get_html_dashboard_card_row(['workhour' => $workhour, 'date' => $date, 'costcenters' => $costcenters])
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
        $id_costcenter = $this->request->getPost('id_costcenter');
        $hours = $this->request->getPost('hours');

        if (!empty($id_costcenter)) {
            $this->workhourmodel->set('id_costcenter', $id_costcenter);
        };

        if (!empty($hours)) {
            $this->workhourmodel->set('hours', $hours);
        };

        $this->workhourmodel->update($id);

        $return = [
            'success' => true,
            'message' => 'Arbeitsstunde wurde aktualisiert'
        ];

        return $this->response->setJSON($return);
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
