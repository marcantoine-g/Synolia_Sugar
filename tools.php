<?php

class Tools 
{
    public $instance_url = "https://sg-exercices.demo.sugarcrm.eu/rest/v11";
    private $oauth_token = null;

    // Permet d'appeler l'API
    public function makeRequest(String $input_url = '', array $arguments = [], String $method = 'POST')
    {
        $url = $this->instance_url . $input_url;

        // Init
        $request = curl_init($url);
        curl_setopt($request, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        curl_setopt($request, CURLOPT_HEADER, false);
        curl_setopt($request, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($request, CURLOPT_FOLLOWLOCATION, 0);

        // Token nécessaire ?
        if($this->oauth_token){
            curl_setopt($request, CURLOPT_HTTPHEADER, array(
                "Content-Type: application/json",
                "oauth-token: {$this->oauth_token}"
            ));
        } else {
            curl_setopt($request, CURLOPT_HTTPHEADER, array(
                "Content-Type: application/json",
            ));
        }

        // Convertion des arguments
        if(!empty($arguments)){
            if($method === 'GET') $url .= "?" . http_build_query($arguments);
            else {
                $json_arguments = json_encode($arguments);
                curl_setopt($request, CURLOPT_POSTFIELDS, $json_arguments);
            }
        }

        //Execution de la request
        $response = curl_exec($request);
        if( ! $response = curl_exec($request))
        {
            trigger_error(curl_error($request));
        }
        curl_close($request);

        return json_decode($response);
        }

    // Permet d'initialiser le token
    public function setToken(String $token = null)
    {
        $this->oauth_token = $token;
    }
}
