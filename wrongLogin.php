<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
            crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<!-- Topics -->
<nav class="navbar navbar-expand-lg navbar-light bg-light mb-3">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="index.php">Accueil</a>
        </li>
    </ul>
</nav>
<body>
<div class="container col-sm-8" id="contact">
    <h2>Authentification</h2>
    <hr><br>
    <section id="errors" class="container alert alert-danger" style="display: block">
        <div class="container">
            <div class="row">
                <div class="col-md-1">
                    <span class="material-icons">error</span>
                </div>
                <div class="col-md-11">
                    <p>Identifiant ou mot de passe incorrect</p>
                </div>

            </div>

        </div>

    </section>
    <h3>Renseignez les champs pour vous connecter</h3>
    <br>
    <form method="post" action="controller.php?func=connect">
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text"><span class="material-icons">
                      perm_identity
                      </span></div>
            </div>
            <input class="form-control" type="text" name="username" placeholder="Nom d'utilisateur" >
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Mots de passe</label>
            <input type="password" name="userpassword" class="form-control" id="exampleInputPassword1">
        </div>
        <br />
        <button class="btn btn-primary" name="sendForm" type="submit">Connexion</button>
    </form>

</div>

</body>

</html>

<?php

?>
