<?php

$instance_url = "https://sg-exercices.demo.sugarcrm.eu/rest/v11";
$username = "melissa";
$password = "qVKbo6obKxDVbVvVfJ5EN5i529Lfkmf7W7MA";

//Login - POST /oauth2/token
$auth_url = $instance_url . "/oauth2/token";

$oauth2_token_arguments = array(
    "grant_type" => "password",
    "client_id" => "sugar", 
    "client_secret" => "",
    "username" => $username,
    "password" => $password,
    "platform" => "base" 
);

$auth_request = curl_init($auth_url);
curl_setopt($auth_request, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
curl_setopt($auth_request, CURLOPT_HEADER, false);
curl_setopt($auth_request, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($auth_request, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($auth_request, CURLOPT_FOLLOWLOCATION, 0);
curl_setopt($auth_request, CURLOPT_HTTPHEADER, array(
    "Content-Type: application/json"
));

//convert arguments to json
$json_arguments = json_encode($oauth2_token_arguments);
curl_setopt($auth_request, CURLOPT_POSTFIELDS, $json_arguments);

//execute request
if( ! $oauth2_token_response = curl_exec($auth_request))
{
    trigger_error(curl_error($auth_request));
}
curl_close($auth_request);

$oauth_token = json_decode($oauth2_token_response)->access_token;


// Récupération des Contacts avec la méthode POST
$fetch_contact_url = $instance_url . "/Contacts/filter";
$contact_filter_arguments = array(
    "filter" => array(
        array(
            '$or' => array(
                array(
                    //name starts with 'a'
                    "last_name" => array(
                        '$contains'=>"b",
                    )
                ),
                array(
                    //name starts with 'b'
                    "first_name" => array(
                        '$contains'=>"a"
                    )
                )
            ),
        ),
    ),
    "max_num" => 100000,
    "offset" => 0,
    "fields" => ["first_name", "last_name", "primary_address_street", "primary_address_city", "primary_address_state", "primary_address_postalcode", "primary_address_country", "email1"],
    "order_by" => "date_entered",
);


$fetch_contact_request = curl_init($fetch_contact_url);
curl_setopt($fetch_contact_request, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
curl_setopt($fetch_contact_request, CURLOPT_HEADER, false);
curl_setopt($fetch_contact_request, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($fetch_contact_request, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($fetch_contact_request, CURLOPT_FOLLOWLOCATION, 0);
curl_setopt($fetch_contact_request, CURLOPT_HTTPHEADER, array(
    "Content-Type: application/json",
    "oauth-token: {$oauth_token}"
));

//convert arguments to json
$json_arguments = json_encode($contact_filter_arguments);
curl_setopt($fetch_contact_request, CURLOPT_POSTFIELDS, $json_arguments);

//execution de la request
$fetch_contact_response = curl_exec($fetch_contact_request);
if( ! $fetch_contact_response = curl_exec($fetch_contact_request))
{
    trigger_error(curl_error($fetch_contact_request));
}
curl_close($fetch_contact_request);

//decode json
$fetch_contact_response_obj = json_decode($fetch_contact_response);


// On récupère l'ID du premier contact pour récupérer ses tickets liés 
if(!empty($fetch_contact_response_obj->records)) $first_contact_id = $fetch_contact_response_obj->records[0]->id;
else return 0;


// Récupération des tickets du premier contact avec la méthode GET 
$fetch_cases_url = $instance_url . "/Contacts/$first_contact_id/link/cases/filter";
$cases_filter_arguments = array(
    "filter" => array(
        array(
            "status" => "Closed"
        )
    ),
    "max_num" => 10000,
    "offset" => 0,
    "order_by" => "date_entered",

);

$fetch_cases_url .= "?" . http_build_query($cases_filter_arguments);

$fetch_cases_request = curl_init($fetch_cases_url);
curl_setopt($fetch_cases_request, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
curl_setopt($fetch_cases_request, CURLOPT_HEADER, false);
curl_setopt($fetch_cases_request, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($fetch_cases_request, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($fetch_cases_request, CURLOPT_FOLLOWLOCATION, 0);
curl_setopt($fetch_cases_request, CURLOPT_HTTPHEADER, array(
    "Content-Type: application/json",
    "oauth-token: {$oauth_token}"
));

//execution de la request
if( ! $fetch_cases_response = curl_exec($fetch_cases_request))
{
    trigger_error(curl_error($fetch_cases_request));
}
curl_close($fetch_cases_request);

//decode json
$fetch_cases_response_obj = json_decode($fetch_cases_response);
// print_r($fetch_cases_response);


// Ajout d'un ticket au contact
$post_case_url = $instance_url . "/Contacts/$first_contact_id/link/cases";

$post_case_arguments = array(
    "name" => "NEW TEST 7",
    "description" => "test description",
    "type" => "Administration",
    "status" => "New",
);

$post_case_request = curl_init($post_case_url);
curl_setopt($post_case_request, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
curl_setopt($post_case_request, CURLOPT_HEADER, false);
curl_setopt($post_case_request, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($post_case_request, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($post_case_request, CURLOPT_FOLLOWLOCATION, 0);
curl_setopt($post_case_request, CURLOPT_HTTPHEADER, array(
    "Content-Type: application/json",
    "oauth-token: {$oauth_token}"
));

//convert arguments to json
$json_arguments = json_encode($post_case_arguments);
curl_setopt($post_case_request, CURLOPT_POSTFIELDS, $json_arguments);

//execution de la request
if( ! $post_case_response = curl_exec($post_case_request))
{
    trigger_error(curl_error($post_case_request));
}
curl_close($post_case_request);

//decode json
$post_case_response_obj = json_decode($post_case_response);
print_r($post_case_response);
