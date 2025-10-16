<?php

namespace App\Controllers;

use App\Utils\AbstractController;
use Config\Database;

class HomeController extends AbstractController
{
    public function index()
    {
        $mongo = Database::getConnection();
        require_once(__DIR__ . '/../Views/home.view.php');
    }
}
