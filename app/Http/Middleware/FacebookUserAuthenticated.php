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

        // Set Access Token
        $accessToken = $request->session()->exists('facebook_access_token')
            ? $request->session()->get('facebook_access_token')
            : $helper->getAccessToken();

        // Redirect to login page
        if(!isset($accessToken)):
            return redirect()->route('login');
        endif;

        // Generate Default Access Token
        if(!$request->session()->exists('facebook_access_token')):
            $oAuth2Client = $this->fb->getOAuth2Client();
            $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken((string)$accessToken);
            $request->session()->push('facebook_access_token', (string)$longLivedAccessToken);
        endif;

        // Set Default Access Token
        $this->fb->setDefaultAccessToken(
            $request->session()->get('facebook_access_token')
        );

        // Redirect to back
        if($request->has('code')):
            redirect()->route('home');
        endif;

        return $next($request);
    }
}
