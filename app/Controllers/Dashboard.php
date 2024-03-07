<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function __construct()
    {

    }

    public function index(): string
    {
        return view('partials/header') .
            view('home') .
            view('partials/footer');
    }
}
