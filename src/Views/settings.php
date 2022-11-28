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

<?php
    // echo $register['email'];
    // echo $register['pseudo'];
?>

<form action="../Controllers/changemdp.php" method="post" class="account">

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
            <input type="submit" value="Subscribe!">
        </div>

        <div class="button-delete">
            <a href="../Controllers/delete.php">delete your account</a>
        </div>

</form>

</body>
</html>