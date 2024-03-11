<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\WorkhourModel;
use CodeIgniter\HTTP\ResponseInterface;

class Workhour extends BaseController
{
    private WorkhourModel $workhourmodel;

    public function __construct()
    {
        $this->workhourmodel = new WorkhourModel();
    }

    public function create()
    {

    }

    public function read($id)
    {

    }

    /**
     * @throws \ReflectionException
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
    }
}
