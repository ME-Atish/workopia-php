<?php

$router->get('/' , 'HomeController@index');
$router->get('/listing' , 'ListingController@index');
$router->get('/listings/create' , 'ListingController@create');
$router->get('/listing' , 'ListingController@show');

