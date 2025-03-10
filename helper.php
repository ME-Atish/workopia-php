<?php

/**
 * Get the base params
 * 
 * @param string $path
 * @return string
 */


function basePath($path = "")
{
    return __DIR__ . "/" . $path;
}


/**
 * Load a view
 * 
 * @param string $name
 * @return void
 * 
 */

function loadView ($name){

    require basePath("views/{$name}.view.php");

}


/**
 * Load a partials
 * 
 * @param string $name
 * @return void
 * 
 */

 function loadPartials ($name){

    require basePath("views/partials/{$name}.php");

}