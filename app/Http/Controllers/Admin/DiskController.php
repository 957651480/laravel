<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class DiskController extends ApiController
{

    public function index(Request $request)
    {
        $form = $request->all();


    }
}
