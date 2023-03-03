<?php
namespace STDashboard\Controller;

use SilverStripe\Control\Controller;

class WelcomeController extends Controller
{
    private static $url_segment = 'welcome';

    private static $allowed_actions = [

    ];

    public function index()
    {
        return $this->customise([
            'Site' => 'Welcome',
        ])->renderWith('Welcome');
    }

}