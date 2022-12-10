<?php

//create a account *
    require("../Models/models.php");

    if (isset($_POST["button"])){

        $email = $_POST["email"];
        $pseudo = $_POST["pseudo"];
        $password = $_POST["password"];
        $user = new user();
        $verif = $user->verif($email, $pseudo);
        

        if (strlen($verif) != 0) {
            $error = $verif;
        } else {
            $register = $user->register($email,$pseudo,$password);
            $user->image($email);
            header("Location: settings.php");
        }

    }

    require("../Views/register.php");