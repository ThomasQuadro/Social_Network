<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>comment</title>
</head>
<body>
    <div style='border:black 1px solid;'>
    <?php foreach ($commentList as $key) {
        if ($key['id_user'] == $_SESSION['id_user']){   
?>
    <a href="../Controllers/deleteComment.php?id=<?php echo $key['id_comment'];?>">Delete</a>
<?php }?>
        <br><img src="../upload/<?php echo $key['id_user']; ?>" style='width:5%;' alt="">

        <h3><?php echo $key['pseudo'];?></h3>
        <h3><?php echo $key['date'];?></h3>
        <h3><?php echo $key['message'];?></h3></div>
    <?php } ?>
</body>
</html>