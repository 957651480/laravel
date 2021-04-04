<?php


namespace App\Http\Controllers\Admin\File;


use App\Models\File\Disk;
use Inertia\Inertia;

class DiskController extends \App\Http\Controllers\Admin\AdminController
{

    public function index()
    {
        return  Inertia::render('File/Disk/List',[
        ]);
    }

    public function indexApi()
    {
        $paginate =Disk::latest()->paginate(15);
        return api_response()->antiSuccess([
            'total'=>$paginate->total(),
            'data'=>$paginate->items()
        ]);
    }
}