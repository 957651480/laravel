<?php


namespace App\Http\Controllers\Admin\Auth;


use Inertia\Inertia;

class AuthController extends \App\Http\Controllers\Admin\AdminController
{


    public function login()
    {
        return  Inertia::render('Auth/Login',[

        ]);
    }
}
