<?php 

namespace App\Controller;

use \App\Utils\View;

class Home{
    
    public static function getHome()
    {
        return View::render('home', [
            'name' => 'Home',
            'title' => 'h1 da Home',
            ]
        );
    }
}