<?php 

namespace App\Controller;


class CorreiosApi 
{

    public static function sendInformation($method, $payload = [])
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://apihom.correios.com.br/token/v1/autentica',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_HTTPHEADER => $payload,
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        
        return $response;
    }

    private static function generateAccessToken()
    {
        $payload = array(
                'Authorization: Basic ' . base64_encode($_ENV['USER_LOGIN'] . ':' . $_ENV['USER_PASSWORD'])
            );
        $response = JSON_decode(self::sendInformation('POST', $payload));
        return $response->token;
    }


}