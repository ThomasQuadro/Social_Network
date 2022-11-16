<?php

class Variables{
    public string $id_user;
    public string $email;
    public string $pseudo;
    public string $password;
}

class User{

    public PDO $connexion;

    public function __construct(){
        $this->connexion = new PDO('mysql:host=localhost;dbname=social_network;charset=utf8', 'root', '');
    }

    public function register(string $email,string $pseudo, string $password){
        $prepareverif = $this->connexion->prepare(
            "SELECT `email`, `pseudo` FROM `user` WHERE `email`=:email AND `pseudo`=:pseudo"
        );
        $prepareverif->execute(["email" => $email, "pseudo" => $pseudo]);

        $verif = $prepareverif->fetch();

        if ($verif) {
            echo "non";
        } else {
            $prepareregister = $this->connexion->prepare(
                "INSERT INTO user(id_user, email, pseudo, `password`) VALUES (DEFAULT,:email,:pseudo,:password)"
            );
            $sendregister = $prepareregister->execute(['email' => $email, 'pseudo' => $pseudo, 'password' => $password]);
        }
        



        
    }


}