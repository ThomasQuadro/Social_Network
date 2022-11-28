<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Views/login.css">
    <title>Document</title>
</head>
<body>
<div class="container">
  <div class ="bluebar">
    <h2>CONNEXION</h2>
  </div>
  <div class="containercont">
    <h3>Nom de compte ou adresse mail</h3>
    <form action="../Controllers/login.php" method="POST" class="form">
      <div class="block">
        <div div class="col">
          <input type="text" class="adresse2" placeholder="Votre adresse mail..." name="email" required>
        </div>
      </div>
        <div class="col">
          <h3 class="mdp">Mot de Passe</h3>
          <input type="text" class="mdp2" placeholder="Votre mot de passe..." name="password" required>
        </div>

      <input type="submit" value="Valider" class="submit" name="submit">
      <div class="error">
        <?php
          if (isset($_POST['submit'])) {
          echo $error;
          }
        ?>
      </div>
    </form>



  </div>
</div>
</body>
</html>