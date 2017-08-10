<?php

namespace App\Http\Middleware;

use Closure;
use Facebook\Facebook;

class FacebookUserAuthenticated
{
    protected $fb;

    public function __construct(Facebook $fb)
    {
        $this->fb = $fb;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $helper = $this->fb->getRedirectLoginHelper();

        // Set state for Persistent Data Helper
        if ($request->has('state')) {
            $helper->getPersistentDataHandler()->set('state', $request->get('state'));
        }

        // Get Access Token
        $accessToken = $helper->getAccessToken();

        // Redirect to login page
        if(!isset($accessToken)):
            return redirect()->route('login');
        endif;

        // Save Access Token to session
        $request->session()->push('facebook_access_token', (string) $accessToken);

        // Redirect to back
        if($request->has('code')):
            redirect()->route('home');
        endif;

        return $next($request);
    }
}
