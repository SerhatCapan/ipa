<?php

namespace App\Controllers;

use App\Models\UserModel;
use ReflectionException;

class User extends BaseController
{
    private UserModel $usermodel;

    public function __construct()
    {
        $this->usermodel = new UserModel();
    }

    public function index() {
        $user_id = $this->request->getCookie('current_user_id');
        $users = $this->usermodel->findAll();

        if ($user_id === null) {
            $data = [
                'current_user' => null,
                'users' => $users,
                'title' => 'Wähle einen Benutzer',
                'switch_user_button_title' => 'Benutzer auswählen'
            ];

            return view('partials/header') .
                view('/user/index', $data) .
                view('partials/footer');
        }

        $user = $this->usermodel->find($user_id);

        $data = [
            'current_user' => $user,
            'users' => $users,
            'title' => 'Hallo ' . $user['name'],
            'switch_user_button_title' => 'Benutzer wechseln'
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
        $user = $this->usermodel->where('name', '')->first();

        if ($user === null) {
            $this->usermodel->insert([
                'name' => $this->request->getPost('name')
            ]);

            $user = $this->usermodel->find($this->usermodel->getInsertID());
        }
    }

    /**
     * @return \CodeIgniter\HTTP\RedirectResponse
     * @throws ReflectionException
     */
    public function update()
    {
        $name = $this->request->getPost('name');
        $id = $this->request->getPost('id');
        $session = session();

        $user_exists = $this->usermodel
            ->select('name')
            ->where('id !=', $id)
            ->where('name', esc($name))
            ->get()->getResultArray();

        if (!empty($user_exists)) {

            $flashdata = [
                'return' => [
                    'success' => false,
                    'message' => 'Benutzer mit dem Namen existiert schon',
                ]
            ];

            $session->setFlashdata($flashdata);
            return redirect()->to('user');
        }

        $this->usermodel
            ->set('name', $this->request->getPost('name'))
            ->set('date_from_overtime', $this->request->getPost('date-from-overtime'))
            ->update($id);

        $flashdata = [
            'return' => [
                'success' => true,
                'message' => 'Benutzer wurde aktualisiert',
            ]
        ];

        $session->setFlashdata($flashdata);
        return redirect()->to('user');
    }

    /**
     * @return void
     */
    public function delete()
    {
        $id = $this->request->getPost('id');
        $this->usermodel->delete($id);
    }

    /**
     * Switches the user and redirects to the user page
     *
     * @return void
     */
    public function switch() {
        $id = $this->request->getPost('user');
        setcookie('current_user_id', $id, strtotime('+365 days'), '/');
        // redirect didn't work with redirect() form codeigniter
        header("Location: " . base_url() . 'user');
    }
}
