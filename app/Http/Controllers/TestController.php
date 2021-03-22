<?php


namespace App\Http\Controllers;


use Inertia\Inertia;

class TestController extends Controller
{

    public function test()
    {
        return  Inertia::render('Test/Test');
    }

    public function antProTestOne()
    {
        return  Inertia::render('Test/AntProTestOne',[
            'event'=>['title'=>'jkdshkhk']
        ]);
    }

    public function antProTestTwo()
    {
        return  Inertia::render('Test/AntProTestTwo',[
            'event'=>['title'=>'jkdshkhk']
        ]);
    }
}
