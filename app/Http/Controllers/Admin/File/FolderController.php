<?php


namespace App\Http\Controllers\Admin\File;


use Inertia\Inertia;

class FolderController extends \App\Http\Controllers\Admin\AdminController
{

    public function index()
    {
        return  Inertia::render('Test/AntProTestOne',[
            'event'=>['title'=>'jkdshkhk']
        ]);
    }
}