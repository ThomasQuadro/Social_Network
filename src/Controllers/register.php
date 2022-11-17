<?php

require(__DIR__."/../Models/models.php");

$email = $_POST["email"];
$pseudo = $_POST["pseudo"];
$password = $_POST["password"];

$user = new user();
$register = $user->register($email,$pseudo,$password);