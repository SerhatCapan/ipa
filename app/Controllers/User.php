<?php

namespace App\Controllers;

use App\Models\UserModel;
use ReflectionException;

class User extends BaseController
{
    private UserModel $user_model;
    private $session;

    public function __construct()
    {
        $this->user_model = new UserModel();
        $this->session = session();
    }

    public function index() {
        $data = [
            'current_user' => $this->session->get('current_user'),
            'users' => $this->user_model->findAll()
        ];

        return view('partials/header') .
            view('/user/index', $data) .
            view('partials/footer');
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

            $user = $this->user_model->find($this->user_model->getInsertID());
        }

        // $session = session();
        // $session->set($newdata);
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
        $id = $this->request->getPost('user');
        $user = $this->user_model->find($id);

        $this->session->set('current_user', $user);

        // redirect didn't work with redirect() form codeigniter
        header("Location: " . base_url() . 'user');
    }
}
