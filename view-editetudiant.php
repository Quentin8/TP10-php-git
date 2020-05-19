<!doctype html>
<html lang="fr">
<head>
    <title>Update Student · TP n°10</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">

</head>
<nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
    <a class="navbar-brand" href="index.php">TP n°10 langage PHP & SQL</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
    </button>

</nav>
<?php
session_start();
include 'controller.php';
$db = connexpdo('pgsql:dbname=etudiants;host=localhost;port=5432','postgres','new_password');
$id = $_GET['id'];
$sql = "SELECT nom, prenom, note FROM etudiant WHERE id =".$id;
$r = $db->query($sql);
foreach ($r as $data) {
    $nom = $data['nom'];
    $prenom = $data['prenom'];
    $note = $data['note'];
}

echo '<body>
    <div class="container col-sm-8 jumbotron">
    <h1>Create new Student</h1><hr>
        <form action="controller.php?func=updateEtudiant" method="POST">
            <div class="form-group">
                <label>Nom</label>
                <input name="nomUpateStudent" type="text" class="form-control" placeholder="'.$nom.'" value="'.$nom.'" >
            </div>
            <div class="form-group">
                <label>Prénom</label>
                <input name="prenomUpdateStudent" type="text" class="form-control" placeholder="'.$prenom.'" value="'.$prenom.'">
            </div>
            <div class="form-group">
                <label>Note</label>
                <input name="noteUpdateStudent" type="number" class="form-control" min="0" max="20" placeholder="'.$note.'" value="'.$note.'" >
            </div>
            <br>
            <button name = "changeStudentInfo" type="submit" class="btn btn-primary">Validate</button>
        </form>
    </div>
</body>';
?>
</html>
<?php

?>
