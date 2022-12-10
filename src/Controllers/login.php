<?php

//login to your account *
    require('../Models/models.php');

    if (isset($_POST['submit'])){

        $email = $_POST["email"];
        $password = $_POST["password"];
        $pseudo = $email;
        $user = new user();
        $log = $user->login($email,$pseudo,$password);

        if ($log) {
            header('Location: /Social_Network-master/src/Controllers/feed.php');
        } else {
            $error = "Echec de l'authentification, l'email ou le mot de passe invalide !";
        }
    }

    require('../Views/login.php');