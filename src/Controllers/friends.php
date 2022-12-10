<?php

require(__DIR__.'/../Models/models.php');

$security = new security();
$friend = new friendList();

$security->secure();

if(isset($_POST["submit"])) {
    $friends = $_POST["friends"];
    $error = $friend->searchFriend($friends);
}

if(isset($_POST["Accepter"])) {
    $friend->responseRequest("Accepter", $_GET["id"]);
    header("Location: ../Controllers/friends.php");
}

if(isset($_POST["Refuser"]) || isset($_POST["Supprimer"]) ) {
    $friend->responseRequest("Refuser", $_GET["id"]);
    header("Location: ../Controllers/friends.php");
}

$list = $friend->friendList();
$friendsReceive = $friend->friendsReceive();
$friendsRequest = $friend->friendsRequest();


require(__DIR__.'/../Views/friends.php');