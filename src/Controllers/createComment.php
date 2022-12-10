<?php
//create a comment
require('../Models/models.php');

$comment = new comment ();

$commentList = $comment->getComments($_GET['id']);

require('../Views/comment.php');