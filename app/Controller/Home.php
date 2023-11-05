<?php 

namespace App\Controller;

use \App\Utils\View;

class Home{
    
    public static function getHome()
    {
        echo View::render('home', [
            'name' => 'Lista de Países',
            'title' => 'Países',
            'paises' => CorreiosApi::getCountriesMenu(),
            ]
        );
    }

    public static function getCities($sgPais)
    {
        echo View::render('_cidades', [
            'name' => 'Lista de Cidades',
            'title' => 'Cidades',
            'content' => CorreiosApi::listCities($sgPais),
            ]
        );
    }    
}