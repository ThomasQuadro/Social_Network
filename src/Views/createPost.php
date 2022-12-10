<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../creation_forum.css">
  <title>Formulaire de Contact</title>
</head>
<body>

<header class="header">
  <div class="header-logo">
    <a href="/accueil"><img src="../Picture/Icons/logo.png" alt="logo"></a>
  </div>
</header>

<?php if (isset($_POST['boutton'])){
  echo $error;
}?>

<div class="error">
  <a href="/register" class="lien"> connexion </a>
</div>

<div class="container">
  <div class ="bluebar">
    <h2>Créer ton forum !</h2>
  </div>
  <div class="containercont">
    <h3 class="title">INFORMATIONS DU SUJET</h3>
    <form action="" method="POST" class="form">

      <h3 class="title">VOTRE MESSAGE</h3>

      <textarea class="obj2" placeholder="Description..." name="message" minlength=3 maxlength=399 required ></textarea>

      <input type="submit" name="boutton" value="Valider" class="submit">
    </form>
  </div>
</div>