<?php

namespace App\Controllers;

use App\Models\Task;
use App\Utils\AbstractController;

class HomeController extends AbstractController
{
    public function index()
    {
        $task = new Task(null, null, null, null, null, null);
        //$resultTasks = $task->getAllTasks();
        $tasksUrgent = $task->getTasksByStatus('Urgent');
        //$this->debug($tasksUrgent);

        if (isset($_POST['editStatus'])) {
            $id = htmlspecialchars($_POST['id']);
            $status = new Task($id, null, null, null, null, null);

            $taskExist = $status->getTaskById();
            if ($taskExist) {
                //$this->debug($taskExist);
                $status = 'Terminé';
                $today = date('Y-m-d');
                $taskExist->setStatus($status);
                $taskExist->setModificationDate($today);
                //$this->debug($taskExist);

                $taskExist->editTask();
                $this->redirectToRoute('/', 302);
            }
        }

        require_once(__DIR__ . '/../Views/home.view.php');
    }
}
