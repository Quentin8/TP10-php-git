<?php
session_start();
include "connexpdo.php";
$connectedInfos = false;
if(isset($_GET['func'])){
    if($_GET['func'] == "createUser"){
        createUser();
        header("Location: http://localhost/PHP/TP10-php-git/index.php");
    }

    if($_GET['func'] == "connect"){
        $connectedInfos = connect();
        if($connectedInfos[0]){//espace connecté
            session_start();
            header("Location: http://localhost/PHP/TP10-php-git/viewadmin.php");
            $_SESSION['userId'] = $connectedInfos[1];//variable de session
            $_SESSION['userName'] = $connectedInfos[2];
        }else{
            header("Location: http://localhost/PHP/TP10-php-git/wrongLogin.php");
        }
    }


    if($_GET['func'] == 'addStudent'){//ajout etudiant
        if(isset($_SESSION['userId'])){
            addNewStudent();
            header("Location: http://localhost/PHP/TP10-php-git/viewadmin.php");
        }
        else{
            header("Location: http://localhost/PHP/TP10-php-git/wrongLogin.php");
        }

    }



    if($_GET['func'] == 'updateEtudiant'){
        if(isset($_POST['delete'])){
            if(isset($_SESSION['userId'])){
                deleteStudent();
                header("Location: http://localhost/PHP/TP10-php-git/viewadmin.php");
            }
            else{
                header("Location: http://localhost/PHP/TP10-php-git/wrongLogin.php");
            }
        }
        if(isset($_POST['update'])){
            $_SESSION['studentModifId'] = $_POST['student'];
            if($_SESSION['studentModifId']){
                $idStudent = $_SESSION['studentModifId'];
                header("Location: http://localhost/PHP/TP10-php-git/view-editetudiant.php?id=$idStudent");
            }else{
                header("Location: http://localhost/PHP/TP10-php-git/viewadmin.php");
            }

        }
        if(isset($_POST['disconnect'])){
            unset($_SESSION['userId']);
            unset($_SESSION['userName']);
            unset($_SESSION['studentModifId']);
            header("Location: http://localhost/PHP/TP10-php-git/index.php");
        }
        if(isset($_POST['changeStudentInfo'])){
            changeStudent($_POST['nomUpateStudent'],$_POST['prenomUpdateStudent'],$_POST['noteUpdateStudent'],$_SESSION['studentModifId']);
            header("Location: http://localhost/PHP/TP10-php-git/viewadmin.php");

        }

    }

}
function changeStudent($nom, $prenom, $note, $idEtudiant){
    $conn = connexpdo('pgsql:dbname=etudiants;host=localhost;port=5432','postgres','new_password');
    $req = "UPDATE etudiant SET nom = '$nom', prenom = '$prenom', note = $note WHERE id= $idEtudiant";
    $sqlr = $conn->query($req);
    $sqlr->execute();

}

function deleteStudent(){
    $conn = connexpdo('pgsql:dbname=etudiants;host=localhost;port=5432','postgres','new_password');
    $studentId = $_POST['student'];
    $request1 = "DELETE FROM etudiant WHERE id = $studentId";
    $sqlR1 = $conn->query($request1);
    $sqlR1->execute();
}

function addNewStudent(){
    session_start();
    $requestCountStudent = "SELECT count (*) FROM etudiant";
    $conn = connexpdo('pgsql:dbname=etudiants;host=localhost;port=5432','postgres','new_password');
    $sqlR1 = $conn->query($requestCountStudent);
    $sqlR1->execute();
    $result = $sqlR1->fetch();
    //renvoit le nb d'entrées
    $request1 = "INSERT INTO etudiant (id, user_id, nom,prenom,note) VALUES (?, ?, ?, ?, ?)";

    if($result['count'] != 0){//cas où deja etudiants dans database
        $requestIdStudent = "SELECT MAX (id) FROM etudiant";
        $sqlR2 = $conn->query($requestIdStudent);
        $sqlR2->execute();
        $result = $sqlR2->fetch();

        $sqlR3 = $conn->prepare($request1);
        $identifiant = $result[0]+1;
        $sqlR3->execute([$identifiant,$_SESSION['userId'],$_POST['lastName'],$_POST['firstName'],$_POST['userNote']]);
    }else{//cas sans etudiants db
        $sqlR1 = $conn->prepare($request1);
        $sqlR1->execute([$result['count'],$_SESSION['userId'],$_POST['lastName'],$_POST['firstName'],$_POST['userNote']]);
    }




}
function createUser(){

    //pas besoin de verifier si les champs ont été tous remplis car required
    $mdp = password_hash($_POST['userpassword'],PASSWORD_DEFAULT);
    $requestCount = "SELECT MAX (id) FROM utilisateur";
    $conn = connexpdo('pgsql:dbname=etudiants;host=localhost;port=5432','postgres','new_password');
    $sqlR1 = $conn->query($requestCount);
    $sqlR1->execute();
    $result = $sqlR1->fetch();
    $request1 = "INSERT INTO utilisateur (id, login, password,mail,nom,prenom) VALUES (?, ?, ?, ?, ?, ?)";
    $sqlR1 = $conn->prepare($request1);
    $sqlR1->execute([$result['max']+1,$_POST['username'],$mdp,$_POST['useremail'],$_POST['userlast'],$_POST['userfirst']]);
}

function connect(){
    $conn = connexpdo('pgsql:dbname=etudiants;host=localhost;port=5432','postgres','new_password');
    $log = $_POST['username'];
    $request = "SELECT id , password,nom FROM utilisateur WHERE login = '$log'";
    $sqlReq = $conn->query($request);
    $sqlReq->execute();
    $result = $sqlReq->fetchAll();
    $infos = array();
    if(password_verify($_POST['userpassword'],$result[0]['password'])){
        $infos[0] = true;
        $infos[1] = $result[0]['id'];
        $infos[2] = $result[0]['nom'];
        return $infos;
    }
    $infos[0] = false;
    return $infos;

}

function readEtudiant(){
    $conn = connexpdo('pgsql:dbname=etudiants;host=localhost;port=5432','postgres','new_password');
    $userId = $_SESSION['userId'];
    $query = "SELECT id, nom, prenom FROM etudiant WHERE user_id = '$userId'";
    $numero = $conn->query($query);
    foreach ($numero as $data){
        echo "<option value=".$data['id'].">".$data['nom']. " " . $data['prenom'] . "</option>";
    }
}
?>

