<?php


namespace App\Http\Controllers;


use Inertia\Inertia;

class TestController extends Controller
{

    public function test()
    {
        return  Inertia::render('Test/Test');
    }

    public function antProTest()
    {
        return  Inertia::render('Test/AntProTest');
    }
}
