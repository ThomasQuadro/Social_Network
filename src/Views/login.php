<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
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
      <!-- <h3 class="title" >INFORMATIONS PERSONNELLES</h3>

      <div class="block">
        <div class="col">
          <label class="prenom">Prénom</label>
          <input type="text" class="prenom2" placeholder="Votre prénom..." name="firstname" required>
        </div>
        <div class="col">
          <label class="nom">Nom</label>
          <input type="text" class="nom2" placeholder="Votre nom..." name="lastname" required>
        </div>
      </div>

      <div class="block">
        <div class="col">
          <label class="langue">Langue</label>
          <select class="langue2" name="lang" required>
            <option value="Francais" class="fr">Francais</option>
          </select>
        </div>
        <div class="col">
          <label class="dn">Date de Naissance</label>
          <input type="date" class="dn2" placeholder="Votre date de naissance..." name="born" required>
        </div>
      </div> -->
      <!-- pas fait name-->

        <div class="col">
          <h3 class="mdp">Mot de Passe</h3>
          <input type="text" class="mdp2" placeholder="Votre mot de passe..." name="password" required>
        </div>

      <input type="submit" value="Valider" class="submit">
    </form>
  </div>
</div>
</body>
</html>