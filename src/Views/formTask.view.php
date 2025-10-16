<?php
require_once(__DIR__ . "/partials/head.view.php");
?>
<h1 class="text-center text-warning fw-bold m-2">Ajouter une tache :</h1>
<form method="POST">
    <label for="title">Titre</label>
    <input type="text" name="title">
    <label for="description">Description de la tache</label>
    <textarea name="description" rows="10"></textarea>
    <label for="status">Statut</label>
    <select name="status">
        <option value="Urgent">Urgente</option>
        <option value="A faire">A faire</option>
        <option value="En cours">En cours</option>
    </select>
    <button type="submit" name="addTask">Ajouter</button>
</form>
<?php
require_once(__DIR__ . "/partials/footer.view.php");
?>