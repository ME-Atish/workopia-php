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

function loadView($name, $data = [])
{

    $viewPath = basePath("views/{$name}.view.php");

    if (file_exists($viewPath)) {
        extract($data);
        require $viewPath;
    } else {
        echo "views {$name} not found";
    }
}


/**
 * Load a partials
 * 
 * @param string $name
 * @return void
 * 
 */

function loadPartials($name)
{

    $partialsPath = basePath("views/partials/{$name}.php");

    if (file_exists($partialsPath)) {
        require $partialsPath;
    } else {
        echo "partials {$name} not found";
    }
}


/**
 * Inspect a value(s)
 * 
 * @param mixed $value
 * @return void
 * 
 */

function inspect($value)
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
}



/**
 * Inspect a value(s) and die
 * 
 * @param mixed $value
 * @return void
 * 
 */

function inspectAndDie($value)
{
    echo "<pre>";
    die(var_dump($value));
    echo "</pre>";
}
