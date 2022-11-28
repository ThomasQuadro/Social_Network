<?php

require(__DIR__."/../Models/models.php");

$password = $_POST["password"];
$password1 = $_POST["password1"];
$password2 = $_POST["password2"];

$user = new user();
$register = $user->changeMdp($password, $password1, $password2);
require(__DIR__."/../Views/settings.php");