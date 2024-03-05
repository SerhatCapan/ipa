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
     * Creates User
     *
     * @return void
     * @throws ReflectionException
     */
    public function create()
    {
        $data = [
            'name' => $this->request->getPost('name')
        ];

        $this->user_model->create_user($data);
    }

    /**
     * Deletes User
     *
     * @return void
     */
    public function delete()
    {
        $id = $this->request->getPost('id');
        $this->user_model->delete_user($id);
    }

    /**
     * Switches user
     *
     * @return void
     */
    public function switch() {

        // TODO: program the switch

        // the new user that should be switched to
        $to = $this->request->getPost('to');
        redirect('/');
    }
}
