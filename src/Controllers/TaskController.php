<?php

namespace App\Controllers;

use App\Utils\AbstractController;

class TaskController extends AbstractController
{
    public function addTask()
    {
        if (isset($_POST['addTask'])) {
            $title = htmlspecialchars($_POST['title']);
            $description = htmlspecialchars($_POST['description']);
            $status = htmlspecialchars($_POST['status']);

            $this->totalCheck('title', $title);
            $this->totalCheck('description', $description);
            $this->totalCheck('status', $status);

            //$this->debug($this->arrayError);
        }
        require_once(__DIR__ . "/../Views/formTask.view.php");
    }
}
