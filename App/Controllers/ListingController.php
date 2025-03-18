<?php

namespace App\Controllers;

use Framework\Database;

class ListingController
{
    protected $db;

    public function __construct()
    {

        $config = require basePath("config/db.php");
        $this->db = new Database($config);
    }

    public function index()
    {
        $listings = $this->db->query("SELECT * FROM listing")->fetchAll();

        loadView("/listing/index", [
            'listings' => $listings
        ]);
    }

    public function create()
    {
        loadView("/listing/create");
    }
    
    public function show($params)
    {
        $id = $params["id"] ?? "";

        $params = [
            "id" => $id
        ];


        $listing = $this->db->query("SELECT * FROM listing where id = :id", $params)->fetch();

        
        if(!$listing){
            ErrorController::notFound("Listing not found");
        }
        loadView('listing/show', [
            'listing' => $listing
        ]);
    }
}
