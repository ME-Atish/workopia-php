<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Validation;

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


        if (!$listing) {
            ErrorController::notFound("Listing not found");
        }
        loadView('listing/show', [
            'listing' => $listing
        ]);
    }

    public function store()
    {
        $allowedFields = [
            'title',
            'description',
            'salary',
            'tags',
            'company',
            'address',
            'city',
            'state',
            'phone',
            'email',
            'requirement',
            'benefits'
        ];
        $newListingData = array_intersect_key($_POST, array_flip($allowedFields));

        $newListingData['user_id'] = 1;
        $newListingData = array_map('sanitize', $newListingData);

        $requiredFields = [
            'title',
            'description',
            'email',
            'city',
            'state',
            'salary'
        ];
        $errors = [];
        foreach ($requiredFields as $field) {
            if (empty($newListingData[$field]) || !Validation::string($newListingData[$field])) {
                $errors[$field] = ucfirst($field) . ' is required';
            }
        }

        if (!empty($errors)) {
            loadView('listing/create', [
                'errors' => $errors
            ]);
        } else {
            $fields = [];
            foreach ($newListingData as $field => $value) {
                $fields[] = $field;
            }

            $fields = implode(', ', $fields);

            $values = [];

            foreach ($newListingData as $field => $value) {
                //Convert empty string to null
                if ($value === '') {
                    $newListingData[$field] = null;
                }

                $values[] = ':' . $field;
            }

            $values = implode(', ', $values);

            $query = "INSERT INTO listing ({$fields}) VALUES ({$values})";
            $this->db->query($query, $newListingData);
            redirect('/listing');
        }
    }
}
