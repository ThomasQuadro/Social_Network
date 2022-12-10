<?php

//see all posts *
    require('../Models/models.php');
        $arraypost = new post();
        $comment = new comment ();

        if (isset($_POST['send'])) {
            $idpost = $_GET['id'];
            $message = $_POST['comment'];
            var_dump($idpost,$message);
            $comment->createComment($idpost,$message);
            header("Location: post.php");
        }

        $rows = $arraypost->affichage();
        
    require('../Views/posts.php');