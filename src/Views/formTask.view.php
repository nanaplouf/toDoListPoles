<?php
require_once(__DIR__ . "/partials/head.view.php");
?>
<h1 class="text-center text-warning fw-bold m-2">Ajouter une tache :</h1>
<form method="POST">
    <div class="col-md-4 mx-auto d-block mt-5">
        <div class="mb-3">
            <label for="title" class="form-label fw-bold text-white">Titre</label>
            <input type="text" name="title" class="form-control">
            <?php
            if (isset($this->arrayError['title'])) {
                echo "<p class='text-danger'> {$this->arrayError['title']} </p>";
            }
            ?>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label fw-bold text-white">Description de la tache</label>
            <textarea name="description" rows="10" class="form-control"></textarea>
            <?php
            if (isset($this->arrayError['description'])) {
                echo "<p class='text-danger'> {$this->arrayError['description']} </p>";
            }
            ?>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label fw-bold text-white">Statut</label>
            <select name="status" class="form-select">
                <option value="Urgent">Urgente</option>
                <option value="A faire">A faire</option>
                <option value="En cours">En cours</option>
            </select>
            <?php if (isset($this->arrayError['status'])) {
            ?>
                <p class='text-danger'><?= $this->arrayError['status'] ?></p>
            <?php
            } ?>
        </div>
        <button class="btn btn-warning" type="submit" name="addTask">Ajouter</button>
    </div>
</form>
<?php
require_once(__DIR__ . "/partials/footer.view.php");
?>