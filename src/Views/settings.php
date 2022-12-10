<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="">
    <title>Settings</title>
</head>
<body>

<img src="<?php echo "../upload/".$_SESSION['id_user'];?>" style='width:10%;' alt="">

<?php
    foreach ($info as $key) {
?>
<h3><?php echo $key['email']?> </h3>
<h3><?php echo $key['pseudo']?> </h3>

<?php } 
if (isset($_POST['button_mdp']) || isset($_POST['changeimg'])){
    echo $error;
}

?>

<form action="../Controllers/settings.php" method="post" class="form-example" enctype="multipart/form-data">

        <div class="form-exemple">
            <label for="file">Fichier</label>
            <input type="file" name="file" required>
        </div>

        <div class="form-example">
            <input type="submit" value="Subscribe!" name="changeimg">
        </div>

</form>

<form action="" method="post" class="account">

        <div class="account">
            <label for="email">ancien mdp: </label>
            <input type="password" name="password" id="password" required>
        </div>

        <div class="account">
            <label for="pseudo">nouveau mdp: </label>
            <input type="password" name="password1" id="password1" required>
        </div>

        <div class="account">
            <label for="password">confirmer nouveau mdp: </label>
            <input type="password" name="password2" id="password2" required>
        </div>

        <div class="account">
            <input type="submit" name="button_mdp" value="Subscribe!">
        </div>

</form>
<div class="button-delete">
    <a href="../Controllers/delete.php">delete your account</a>
</div>

<div class="button-disconect">
    <a href="../Controllers/disconnect.php">disconnect</a>
</div>

</body>
</html>