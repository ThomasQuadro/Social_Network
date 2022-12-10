<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts</title>
</head>
<body>
    <h1>Liste des Publications</h1>
    
    <?php     
        if (sizeof($rows) == 0) {
            echo "Vous n'avez pas encore ajouté d'amis à votre liste d'amis";
        }
        foreach ($rows as $row) {
            echo "<div style='border:black 1px solid;'>";
            if ($row['id_user'] == $_SESSION['id_user']){       
    ?>
    <a href="../Controllers/deletePost.php?id=<?php echo $row['id_publication'];?>">Delete</a>
    
    <?php } ?>

    <br><img src="../upload/<?php echo $row['id_user']; ?>" style='width:5%;' alt=""><h3><?php echo $row['pseudo']." "; echo $row['date']; ?></h3>
    <h3><?php echo $row['message']; ?></h3>
    <a href="../Controllers/comment.php?id=<?php echo $row['id_publication'];?>">Voir Commentaires</a>

    <form action="../Controllers/post.php?id=<?php echo $row['id_publication'];?>" method="post">
        <label for="comment">Comment</label>
        <input type="text" name='comment' minlength=2 maxlength=120>
        <input type="submit" name="send">
    </form>

    <a href="../Controllers/feed.php?page=" class="previous">&laquo; Précédant</a>
    <a href="../Controllers/feed.php?page=" class="next">Suivant &raquo;</a>

    </div>
    
    <?php } ?>

    <?php
        for ($i = 1; $i <= $nbpage; $i++) {
    ?>
        <a href="../Controllers/feed.php?page=<?php echo $i; ?>" class="next"><?php echo $i; ?> </a>

    <?php } ?>
</body>
</html>