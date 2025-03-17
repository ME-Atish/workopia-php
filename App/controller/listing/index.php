<?php

use Framework\Database;

$config = require basePath("config/db.php");

$db = new Database($config);

$listings = $db->query("SELECT * FROM listing")->fetchAll();

loadView("listing/index", [
    'listings' => $listings
]);
