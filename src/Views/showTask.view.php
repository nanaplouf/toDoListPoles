<?php
require_once(__DIR__ . "/partials/head.view.php");
?>
<h1 class="text-center text-warning fw-bold m-2">Ma tache</h1>
<h2><?= $myTask->getTitle() ?></h2>
<p><?= $myTask->getStatus() ?></p>
<p><?= $myTask->getDescription() ?></p>
<p><?= $myTask->getCreationDate() ?></p>
<p><?= $myTask->getModificationDate() ?></p>
<a href="/modifier?id=<?= $myTask->getId() ?>" class="btn btn-warning">Modifier</a>
<form action="/supprimer?id=<?= $myTask->getId() ?>" method="post">
    <input type="hidden" value="<?= $myTask->getId() ?>" name="id">
    <button class="btn btn-danger mt-2" name="delete" type="submit">Supprimer</button>
</form>
<?php
require_once(__DIR__ . "/partials/footer.view.php");
?>