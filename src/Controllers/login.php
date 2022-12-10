<?php

//appel du model
require('../Models/models.php');

//si on envoie execute la fonction
if (isset($_POST['submit'])){

    $email = $_POST["email"];
    $password = $_POST["password"];
    $pseudo = $email;
    $user = new user();
    $log = $user->login($email,$pseudo,$password);

    if ($log) {
        //renvoie sur le home
        header('Location: /Social_Network-master/src/Controllers/settings.php'); //a definir
    } else {
        //erreur d'autentification
        $error = "Echec de l'authentification, l'email et/ou le mot de passe ne correspond(ent) pas !";
    }
}

//appel du view
require('../Views/login.php');

//good