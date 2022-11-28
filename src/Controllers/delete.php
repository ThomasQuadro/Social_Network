<?php

require(__DIR__."/../Models/models.php");

$user = new user();
$register = $user->deleteAccount();
require(__DIR__."/../Views/settings.php");
header('location: ../Views/login.php');