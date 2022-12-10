<?php

//ajouter les emojis
    require('../Models/models.php');

    if(isset($_POST['boutton'])){
        $adds = new post();
        $message = $_POST['message'];

        if (strlen($message) >2 && strlen($message) < 400) {
            $envoi = $adds->createPost($message);

            //var_dump(utf8_encode($message));
    
            header('Location: post.php');
        } else {
            $error = "Votre message doit contenir entre 2 et 400 caractères !";
        }
        

    }
    
    require('../Views/createPost.php');
