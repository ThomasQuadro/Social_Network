<?php 

//delete a comment *
    require("../Models/models.php");

    $comment = new comment();
    $comment->deleteComment($_GET['id']);

    header('Location: post.php');