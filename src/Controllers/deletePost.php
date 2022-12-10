<?php
require('../Models/models.php');

$post = new post();
$post->deletePost($_GET['id']);

header('Location: post.php');