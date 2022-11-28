<?php

require(__DIR__.'/../Models/models.php');

$error = "";

$email = $_POST["email"];

$password = $_POST["password"];

$pseudo = $email;

$user = new user();

// if valider
if ($user->login($email,$pseudo,$password)) {
    //renvoie sur le home
    header('Location: /Social_Network-master/src/Controllers/settings.php');
} else {
    //erreur d'autentification
    $error = "Echec de l'authentification";
    require(__DIR__.'/../Views/login.php');
};