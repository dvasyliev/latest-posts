<?php

namespace App\Http\Controllers;

use Facebook\Facebook;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index(Facebook $fb)
    {
        $helper = $fb->getRedirectLoginHelper();
        $login_url = $helper->getLoginUrl(env('APP_URL'), ['email']);

        if (view()->exists('login')) {
            $data = array(
                'login_url' => $login_url
            );

            return view('login', $data);;
        }

        abort(404);
    }
}