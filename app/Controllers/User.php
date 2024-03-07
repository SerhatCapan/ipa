<?php

namespace App\Controllers;

use App\Models\UserModel;
use ReflectionException;

class User extends BaseController
{
    private UserModel $user_model;

    public function __construct()
    {
        $this->user_model = new UserModel();
    }

    /**
     * @return void
     * @throws ReflectionException
     */
    public function create()
    {
        $user = $this->user_model->where('name', '')->first();

        if ($user === null) {
            $this->user_model->insert([
                'name' => $this->request->getPost('name')
            ]);
        }

    }

    /**
     * @return void
     */
    public function delete()
    {
        $id = $this->request->getPost('id');
        $this->user_model->delete($id);
    }

    /**
     * @return void
     */
    public function switch() {
        // TODO: program the switch
        // the new user that should be switched to
        $to = $this->request->getPost('to');
        redirect('/');
    }
}
