<?php

require(__DIR__.'/../Models/models.php');

$friend = $_POST["friends"];

$user = new friendList();

$user->searchFriend($friend);