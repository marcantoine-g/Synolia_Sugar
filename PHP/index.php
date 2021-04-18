<?php
require 'tools.php';

$username = "melissa";
$password = "qVKbo6obKxDVbVvVfJ5EN5i529Lfkmf7W7MA";
$tools = new Tools();

### LOGIN [POST]
// Argument de la requête
$oauth2_token_arguments = array(
    "grant_type" => "password",
    "client_id" => "sugar", 
    "client_secret" => "",
    "username" => $username,
    "password" => $password,
    "platform" => "base" 
);

// Appel API
$login = $tools->makeRequest("/oauth2/token", $oauth2_token_arguments);
$oauth_token = $login->access_token;
// Initialisation du token pour les autres appels
$tools->setToken($oauth_token);


### CONTACTS [METHODE POST]
// Argument de la requête
$contact_filter_arguments = array(
    "filter" => array(
        array(
            '$or' => array(
                array(
                    "last_name" => array(
                        '$contains'=>"b",
                    )
                ),
                array(
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

// Appel API
$contacts = $tools->makeRequest("/Contacts/filter", $contact_filter_arguments);
// print_r($contacts);
// Vérification que la liste est non vide
if(!empty($contacts->records)) $first_contact_id = $contacts->records[0]->id;
else return 0;


### TICKETS [METHODE GET]

// Argument de la requête
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

// Appel API
$tickets = $tools->makeRequest("/Contacts/$first_contact_id/link/cases/filter", $cases_filter_arguments, 'GET');
// print_r($tickets);

### CREATION TICKET [METHODE POST]
// Argument de la requête
$post_case_arguments = array(
    "name" => "NEW TEST 8",
    "description" => "test description",
    "type" => "Administration",
    "status" => "New",
);

// Appel API
$new_ticket = $tools->makeRequest("/Contacts/$first_contact_id/link/cases", $post_case_arguments);
// print_r($new_ticket);