<?php 

namespace App\Controller;

use \App\Utils\View;
use \App\Model\City;

class Home{
    
    public static function getHome()
    {
        echo View::render('home', [
            'name' => 'Lista de Países',
            'title' => 'Países',
            'subtitle' => 'Registros salvos',
            'paises' => CorreiosApi::getCountriesMenu(),
            'datagrid' => (new Home())->getDatagrid(),
            ]
        );
    }

    public static function getCities($sgPais)
    {
        echo View::render('_cidades', [
            'name' => 'Lista de Cidades',
            'title' => 'Cidades',
            'subtitle' => 'Registros salvos',
            'content' => CorreiosApi::listCities($sgPais),
            ]
        );
    }

    public function getDatagrid() 
    {
        $citiesSumary = (new City())->getCitiesSumary();
        $citiesTotal = 0;
        $dataGrid = "
            <table class='table'>
                <tr>
                    <td class='text-bold'>País</td>
                    <td class='align-right text-bold'>Registros</td>
                </tr>";

        foreach ($citiesSumary as $key => $city) {
            $citiesTotal += $city['total']; 
            $dataGrid .= "
                <tr>
                    <td>" . $city['city_country'] . "</td>
                    <td class='align-right'>" . number_format($city['total'], 0, ',', '.') . "</td>
                </tr>";
        }

        $dataGrid .= "
                <tr>
                    <td class='text-bold'>Total de Registros:</td>
                    <td class='align-right text-bold'>" . number_format($citiesTotal, 0, ',', '.') . "</td>
                </tr>
            </table>";
       
        return $dataGrid;
    }
}