<?php

namespace App\Http\Controllers;

use App\Responses\SuccessResponse;

class HomeController extends Controller
{

    public function index()
    {
        return view('landing.index');
    }
    public function authNafath()
    {
        return SuccessResponse::send(1, 'Nafath Auth Success', 200);
    }
}
