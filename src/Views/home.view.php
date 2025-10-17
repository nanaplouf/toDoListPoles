<?php
require_once(__DIR__ . "/partials/head.view.php");
?>
<h1 class="text-center text-warning fw-bold m-2">Bienvenue</h1>
<h2>Voilà les taches :</h2>

<?php
if (!empty($resultTasks)) {
    foreach ($resultTasks as $task) {
?>
        <div class="card" style="width: 18rem;">
            <div class="card-body">
                <h3 class="card-title"><?= $task->getTitle() ?></h3>
                <span class="badge rounded-pill text-bg-warning"><?= $task->getStatus() ?></span>
                <p class="card-text"><?= $task->getDescription() ?></p>
                <a href="#" class="btn btn-primary">voir +</a>
            </div>
        </div>
<?php
    }
} else {
    echo "<p>Vous n'avez pas de tâche !</p>";
}
?>
<?php
require_once(__DIR__ . "/partials/footer.view.php");
?>