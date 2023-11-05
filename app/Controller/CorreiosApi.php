<?php 

namespace App\Controller;


class CorreiosApi 
{
    const countriesFilter = [
        'ARGENTINA',
        'AUSTRIA',
        'AUSTRALIA',
        'BELARUS',
        'CANADA',
        'BOLIVIA',
        'BULGARIA',
        'BELGICA',
        'ESTADOS UNIDOS',
        'ALEMANHA',
        'ITALIA',
        'FRANÇA',
        'BRASIL'
    ];

    private static function sendInformation($method, $url, $payload = [])
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_HTTPHEADER => array('Authorization: Basic ' . base64_encode($_ENV['USER_LOGIN'] . ':' . $_ENV['USER_PASSWORD'])),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        
        return $response;
    }

    private static function generateAccessToken()
    {
        $url = $_ENV['BASE_URL_AUTH'] . '/token/v1/autentica';
        $response = JSON_decode(self::sendInformation('POST', $url));
        return $response->token;
    }

    private static function getCountries()
    {
        $url = $_ENV['BASE_URL'] .'/localidades/v1/paises/';
        $response = JSON_decode(self::sendInformation('GET', $url));
        return $response;
    }

    public static function getCountriesMenu()
    {
        $countries = self::getCountries();
        $response = '';
        $limite = 30;
        $cont = 0;

        foreach ($countries as $key => $country) {
            if (in_array(strtoupper($country->noPais), self::countriesFilter)) {
                $response .= "<option value='$country->sgPais'>$country->noPais</option>" . chr(10) . chr(13);
                $cont++;
            } 
            if ($cont === $limite) break;
        }

        return $response;
    }

    public static function listCities($sgPais)
    {
        $url = $_ENV['BASE_URL'] . "/localidades/v1/paises/$sgPais/cidades?page=1&size=99999";
        $response = self::sendInformation('GET', $url);
        $response = json_decode($response, true);

        return number_format(count($response['cidades']),0, ',', '.') . ' cidades encontradas';
    }
}