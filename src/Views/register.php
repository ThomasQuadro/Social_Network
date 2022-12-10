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
    if (isset($_POST["button"])) {
        echo $error; 
    }
    ?>
    <form action="../Controllers/register.php" method="post" class="form-example" enctype="multipart/form-data">

        <div class="form-exemple">
            <label for="file">Fichier</label>
            <input type="file" name="file" required>
        </div>

        <div class="form-example">
            <label for="email">Enter your email: </label>
            <input type="email" name="email" id="email" required>
        </div>

        <div class="form-example">
            <label for="pseudo">Enter your pseudo: </label>
            <input type="text" name="pseudo" id="pseudo" required>
        </div>

        <div class="form-example">
            <label for="password">Enter your password: </label>
            <input type="password" name="password" id="password" required>
        </div>

        <div class="form-example">
            <input type="submit" name="button" value="Subscribe!">
        </div>

    </form>

</body>
</html>