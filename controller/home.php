<?php
$config = require basePath("config/db.php");

$db = new Database($config);

$listing = $db->query("SELECT * FROM listing")->fetchAll();

loadView("homepage");