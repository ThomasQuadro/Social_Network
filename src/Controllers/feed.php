<?php
//post des copains
require('../Models/models.php');
    $arraypost = new post();
    $comment = new comment ();

    if (isset($_POST['send'])) {
        $idpost = $_GET['id'];
        $message = $_POST['comment'];
        $comment->createComment($idpost,$message);
        header("Location: post.php");
    }

    $page = $_GET['page'];
    $nbelem = 10;

    $nbfeed = $arraypost->count();
    $nbfeed = (int) $nbfeed['COUNT(*)'];
    $nbpage = ceil($nbfeed/$nbelem);

    if(empty($page) || $page > $nbpage) {
        header("Location: ./feed.php?page=1");
    }

    $debut = ($page-1)*$nbelem;

    $rows = $arraypost->feed($debut, $nbelem);
    
require('../Views/feed.php');