<?php

namespace App\Controllers;

use App\Utils\AbstractController;

class TaskController extends AbstractController
{
    public function addTask()
    {
        require_once(__DIR__ . "/../Views/formTask.view.php");
    }
}
