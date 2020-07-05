<?php


namespace App\Http\Controllers\Api\Backend;


use Illuminate\Http\Request;

class FileController extends BackendApiController
{

    public function index(Request $request)
    {
        $request->all();
    }
}
