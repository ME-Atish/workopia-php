<?php
require "../helper.php";


$routes = [
    "/" => "controller/home.php",
    "/listing" => "controller/listing/index.php",
    "/listing/create" => "controller/listing/create.php",
    "404" => "controller/errors/404.php"
];


$uri = $_SERVER["REQUEST_URI"];

if (array_key_exists($uri, $routes)) {
    require basePath($routes[$uri]);
} else {
    require basePath($routes["404"]);
}
