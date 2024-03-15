<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;
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

        if (!$this->usermodel->user_exist($user_id )) {
            $data = [
                'current_user' => null,
                'users' => $users,
                'title' => 'Benutzer',
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
     * @throws ReflectionException
     */
    public function create()
    {
        $name = $this->request->getPost('name');
        $user = $this->usermodel->where('name', $name)->first();
        $session = session();

        if (!empty($user)) {
            $flashdata = [
                'return' => [
                    'success' => false,
                    'message' => 'Benutzer mit dem Namen existiert schon'
                ]
            ];

            $session->setFlashdata($flashdata);
            return redirect()->to('user');
        }

        $this->usermodel->insert([
            'name' => $this->request->getPost('name')
        ]);


        $flashdata = [
            'return' => [
                'success' => true,
                'message' => 'Benutzer wurde erstellt'
            ]
        ];

        $session->setFlashdata($flashdata);
        return redirect()->to('user');

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

    public function delete()
    {
        $id = $this->request->getPost('user');
        $id_user_cookie = $this->request->getCookie('current_user_id');
        $session = session();

        $this->usermodel->delete($id);
        $session = session();

        $flashdata = [
            'return' => [
                'success' => true,
                'message' => 'Benutzer wurde gelöscht',
            ]
        ];

        if ($id === $id_user_cookie) {
            $session->destroy();
        }

        $session->setFlashdata($flashdata);
        return redirect()->to('user');
    }


    /**
     * Switches the user and redirects to the user page
     *
     * Requires:
     * - id
     *
     * @return RedirectResponse
     */
    public function switch() {
        $id = $this->request->getPost('user');
        setcookie('current_user_id', $id, strtotime('+365 days'), '/');
        return redirect()->to('user');
    }
}
