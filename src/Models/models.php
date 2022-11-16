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
        
    }


}