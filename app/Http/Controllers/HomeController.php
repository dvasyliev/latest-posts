<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        echo 'home';
//        if (view()->exists('home')) {
//            $data = $request->attributes->all();
//
//            return view('home', $data);;
//        }
//
//        abort(404);
    }
}
