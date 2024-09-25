<?php

namespace App\Controller;

use App\Model\Post;
use App\Model\User;
use Http\Auth;
use Http\Request;

class HomeController
{
    public function index() {
        return "Hello World";        
    }

    public function getUserDetail($id = null) {
        return User::table()
            ->where('id', $id)
            ->get();

    }

    
    public function saveUser() {
        $request = new Request();

        return $request->all();
    }
}