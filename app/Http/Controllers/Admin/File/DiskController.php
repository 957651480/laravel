<?php


namespace App\Http\Controllers\Admin\File;


use Inertia\Inertia;

class DiskController extends \App\Http\Controllers\Admin\AdminController
{

    public function index()
    {
        return  Inertia::render('File/Disk/List',[
            'event'=>['title'=>'jkdshkhk']
        ]);
    }
}