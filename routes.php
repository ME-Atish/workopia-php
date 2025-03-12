<?php

$router->get('/', 'controller/home.php');
$router->get('/listing', 'controller/listing/index.php');
$router->get('/listing/create', 'controller/listing/create.php');
