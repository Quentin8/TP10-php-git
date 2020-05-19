<!DOCTYPE html>
<html lang="fr">

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <title>Site</title>
</head>

<body>

<?php
session_start();
include "controller.php";
echo '
<div class="container col-sm-8" id="contact">
    <h2>Interface Administrateur</h2>
    <hr><br>
    <h3>Liste des étudiants</h3><hr><br>
    <form method="POST" action="controller.php?func=updateEtudiant">
        <div class="form-group">
            <select class="form-control" name="student">
                <option selected disabled>Sélectionnez un étudiant</option>';
                    readEtudiant();
echo'
                 </select>
        </div>
        <button name="delete" type="submit" class="btn btn-danger">Supprimer</button>
        <button name="update" type="submit" class="btn btn-primary">Modifier</button>
        <button name="disconnect" type="submit" class="btn btn-primary">Déconnexion</button>
        
    </form>
    <br>
    <button class="btn btn-success" onclick="window.open(\'view-newetudiant.php\',\'_self\')">Ajouter un étudiant</button>

</div>';
echo '<div class=container>
            <br>
            <h3 class="text-center">Ma classe</h3>
            <hr><br>
            <div class="row">
                <div class="col-md-8">
                <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Prenom</th>
                        <th scope="col">Note</th>
                    </tr>
                </thead>
                <tbody>
                    ' . studentCounter() .'
                    
                </div>
                <div class="col-md-4">
                    <div class="card" style="width: 18rem;">
                        <img src="classe.jpg" class="card-img-top" alt="ISEN-Nantes">
                        <div class="card-body">
                            <h5 class="card-title">CIR2</h5>
                            <p class="card-text">Classe de Mr <strong>'. $_SESSION['userName'] . '</strong></p>
                         </div>
                         <ul class="list-group list-group-flush">
                            <li class="list-group-item">' . countStudents() .  ' Élèves</li>
                            <li class="list-group-item">' . average() .'</li>
                         </ul>
                       </div>
                </div>
            </div>
            

</div>';
function average(){
    $teacherId = $_SESSION['userId'];
    $request = "SELECT note from etudiant WHERE user_id = $teacherId";
    $conn = connexpdo('pgsql:dbname=etudiants;host=localhost;port=5432','postgres','new_password');
    $sqlR1 = $conn->query($request);
    $sqlR1->execute();
    $result = $sqlR1->fetchAll();
    $sum = 0;
    $counter = 0;
    foreach ($result as $note){
        $counter++;
        $sum += $note['note'];
    }
    $sum = $sum/$counter;
    return "Moyenne de classe : $sum";
}
function countStudents(){
    $teacherId = $_SESSION['userId'];
    $request = "SELECT count (*) from etudiant WHERE user_id = $teacherId ";
    $conn = connexpdo('pgsql:dbname=etudiants;host=localhost;port=5432','postgres','new_password');
    $sqlR1 = $conn->query($request);
    $sqlR1->execute();
    $result = $sqlR1->fetch();
    return $result[0];
}
function studentCounter(){
    $teacherId = $_SESSION['userId'];
    $request = "SELECT nom, prenom, note FROM etudiant WHERE user_id = $teacherId ORDER BY nom";
    $conn = connexpdo('pgsql:dbname=etudiants;host=localhost;port=5432','postgres','new_password');
    $sqlR1 = $conn->query($request);
    $sqlR1->execute();
    $result = $sqlR1->fetchAll();
    $counter = 0;
    $string = "";
    foreach ($result as $student){
        $counter++;
        if($student['note'] < 10){
            $string .= '<tr class="table-danger"><th scope="row">' . $counter . '</th><td>'.$student['nom'] . '</td><td>' . $student['prenom'] . '</td><td>' . $student['note'] . '</td></tr>';
        }
        elseif ($student['note'] >= 16){
            $string .= '<tr class="table-success"><th scope="row">' . $counter . '</th><td>'.$student['nom'] . '</td><td>' . $student['prenom'] . '</td><td>' . $student['note'] . '</td></tr>';
        }else{
            $string .= '<tr><th scope="row">' . $counter . '</th><td>'.$student['nom'] . '</td><td>' . $student['prenom'] . '</td><td>' . $student['note'] . '</td></tr>';
        }

    }
    return $string . "</tbody></table>";

}
?>
</body>
</html>
