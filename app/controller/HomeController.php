<?php

namespace App\Controller;

use App\Model\User;
use Http\Request;
use Http\Response;

class HomeController
{
    public function index() {
        return view('welcome', ['name' => 'Hasan']);
    }

    public function adminPage() {
        return "Hello Admin";
    }

    public function users() {
        // return User::table()
        // ->orderBy('name', 'DESC')
        // ->limit(10)
        // ->get();

        return "Helllo";
    }
}