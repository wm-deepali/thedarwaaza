<?php

namespace App\Http\Controllers;
use App\Traits\LogsApiCalls;

class FrontController extends Controller
{
    use LogsApiCalls;
    public function home()
    {

        return view('front-pages.home');
    }


}