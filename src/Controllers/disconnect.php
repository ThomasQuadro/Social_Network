<?php

require('../Models/models.php');

$user = new user();
$user->disconnect();

header("Location: login.php");