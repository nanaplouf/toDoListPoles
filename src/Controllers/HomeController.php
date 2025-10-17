<?php

namespace App\Controllers;

use App\Models\Task;
use App\Utils\AbstractController;

class HomeController extends AbstractController
{
    public function index()
    {
        $task = new Task(null, null, null, null, null, null);
        $resultTasks = $task->getAllTasks();
        //$this->debug($resultTasks);

        require_once(__DIR__ . '/../Views/home.view.php');
    }
}
