<?php

require(__DIR__.'/../Models/models.php');

$email = $_POST["email"];

$password = $_POST["password"];

$pseudo = $email;

$user = new user();

$user->login($email,$pseudo,$password);