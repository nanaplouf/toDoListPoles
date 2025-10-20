<?php
require_once(__DIR__ . "/partials/head.view.php");
?>
<h1 class="text-center text-warning fw-bold m-2">Bienvenue</h1>
<h2>Les tache Urgente</h2>
<?php
if (!empty($tasksUrgent)) {
    foreach ($tasksUrgent as $task) {
?>
        <div class="card" style="width: 18rem;">
            <div class="card-body">
                <h3 class="card-title"><?= $task->getTitle() ?></h3>
                <span class="badge rounded-pill text-bg-danger"><?= $task->getStatus() ?></span>
                <p class="card-text"><?= $task->getDescription() ?></p>
                <a href="/tache?id=<?= $task->getId() ?>" class="btn btn-primary">voir +</a>
                <form action="" method="post">
                    <input type="hidden" value="<?= $task->getId() ?>" name="id">
                    <button type="submit" class="btn btn-success mt-2" name="editStatus">Terminer</button>
                </form>
            </div>
        </div>
<?php
    }
} else {
    echo "<p>Vous n'avez pas de tâche urgente !</p>";
}
?>
<h2>Les tache A faire</h2>

<h2>Les tache en cours</h2>

<h2>Les tache terminé</h2>

<h2>Voilà les taches :</h2>

<?php
require_once(__DIR__ . "/partials/footer.view.php");
?>