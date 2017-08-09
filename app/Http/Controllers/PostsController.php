<?php

namespace App\Http\Controllers;

use Facebook\Facebook;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function index(Facebook $fb)
    {
        echo 'run PostsController<br>';
        dd($fb);
    }
}