<?php

require(__DIR__."/../Models/models.php");

$user = new user();
$register = $user->settings();
require(__DIR__."/../Views/settings.php");