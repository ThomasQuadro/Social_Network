<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    
    <?php
        if(isset($_POST["submit"])) {
            echo $error;
        }
    ?>

    <form action="../Controllers/friends.php" method="post" class="form-example">

        <div class="form-example">
            <label for="friends">Enter your name friend : </label>
            <input type="text" name="friends" id="friends" required>
        </div>

        <input type="submit" value="Valider" name="submit" class="submit">

    </form>

    <?php
        echo "liste d'amis :"."<br>";
        foreach ($list as $key) {
        echo $key['pseudo']."<br>";
    ?> 
        <form action="../Controllers/friends.php?id=<?php echo $key['id_request']; ?>" method="post" class="form-example">
            <input type="submit" value="Supprimer" name="Supprimer" class="submit">
        </form>
    <?php }
        echo 'demandes reçues :'."<br>";
        foreach ($friendsReceive as $key) {
        echo $key['pseudo']."<br>";
    ?> 
        <form action="../Controllers/friends.php?id=<?php echo $key['id_request']; ?>" method="post" class="form-example">
            <input type="submit" value="Accepter" name="Accepter" class="submit"> 
            <input type="submit" value="Refuser" name="Refuser" class="submit"> 
        </form>
    <?php }
        echo "<br>".'demandes envoyées :'."<br>";
        foreach ($friendsRequest as $key) {
        echo $key['pseudo']."<br>";
    ?> 
        <form action="../Controllers/friends.php?id=<?php echo $key['id_request']; ?>" method="post" class="form-example">
            <input type="submit" value="Supprimer" name="Supprimer" class="submit"> 
        </form>
    <?php } ?>

</body>
</html>