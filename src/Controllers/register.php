<?php

require(__DIR__."/../Models/models.php");

$email = $_POST["email"];
$pseudo = $_POST["pseudo"];
$password = $_POST["password"];

$user = new User();
$register = $user->register($email,$pseudo,$password);