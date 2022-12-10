<?php

require(__DIR__."/../Models/models.php");

$user = new user();
$register = $user->deleteAccount();

header('location: ../Controllers/login.php');

//good