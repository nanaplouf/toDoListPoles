<?php

namespace App\Controllers;

use App\Models\Task;
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

            if (empty($this->arrayError)) {
                $today = date("Y-m-d");
                $task = new Task(null, $title, $description, $status, $today, null);
                $task->saveTask();
                $this->redirectToRoute('/', 200);
            }
        }
        require_once(__DIR__ . "/../Views/formTask.view.php");
    }

    public function show()
    {
        //afficher une tache
        if (isset($_GET['id'])) {
            $id = htmlspecialchars($_GET['id']);
            $task = new Task($id, null, null, null, null, null);
            $myTask = $task->getTaskById();
            if ($myTask) {
                require_once(__DIR__ . "/../Views/showTask.view.php");
            }
            $this->redirectToRoute('/', 302);
        }
        $this->redirectToRoute('/404', 404);
    }

    public function editTask()
    {
        if (isset($_GET['id'])) {
            $id = htmlspecialchars($_GET['id']);
            $task = new Task($id, null, null, null, null, null);
            $myTask = $task->getTaskById();
            if ($myTask) {
                if (isset($_POST['editTask'])) {
                    $title = htmlspecialchars($_POST['title']);
                    $description = htmlspecialchars($_POST['description']);
                    $status = htmlspecialchars($_POST['status']);

                    $this->totalCheck('title', $title);
                    $this->totalCheck('description', $description);
                    $this->totalCheck('status', $status);

                    if (isset($this->arrayError)) {
                        $today = date('Y-m-d');
                        $updateTask = new Task($id, $title, $description, $status, $myTask->getCreationDate(), $today);
                        $updateTask->editTask();
                        $this->redirectToRoute('/tache?id=' . $id, 302);
                    }
                }

                require_once(__DIR__ . "/../Views/formTask.view.php");
            }
            $this->redirectToRoute('/404', 404);
        }
        $this->redirectToRoute('/404', 404);
    }

    public function deleteTask()
    {
        if (isset($_POST['id'])) {
            $id = htmlspecialchars($_POST['id']);
            $task = new Task($id, null, null, null, null, null);
            $myTask = $task->getTaskById();
            if ($myTask) {
                $myTask->deleteTask();
                $this->redirectToRoute('/', 302);
            }
            $this->redirectToRoute('/404', 404);
        }
        $this->redirectToRoute('/404', 404);
    }
}
