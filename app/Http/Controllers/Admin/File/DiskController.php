<?php


namespace App\Http\Controllers\Admin\File;


use App\Models\File\Disk;
use App\Http\Requests\Request;
use Inertia\Inertia;

class DiskController extends \App\Http\Controllers\Admin\AdminController
{

    public function index()
    {
        return  Inertia::render('File/Disk/List',[
        ]);
    }

    public function indexApi(Request $request)
    {
        list($page,$size,$offset)= $request->getFilterAntiPageParam();
        $query = Disk::query();
        $total =$query->count();
        $collection = $query->oldest()->skip($offset)->take($size)->get();
        return api_response()->antiSuccess([
            'total'=>$total,
            'data'=>$collection
        ]);
    }

    public function setting()
    {
        return  Inertia::render('File/Disk/Setting',[
        ]);
    }
}