<?php

// class variables{
//     public string $id_user;
//     public string $email;
//     public string $pseudo;
//     public string $password;
// }

class user{

    public PDO $connexion;

    public function __construct(){
        $this->connexion = new PDO('mysql:host=localhost;dbname=social_network;charset=utf8', 'root', '');
    }


    public function login(string $email, string $pseudo, string $password) 
    {
        $statement = $this->connexion->prepare(
            "SELECT email, pseudo, `password` FROM user WHERE password=? AND email=? OR pseudo=?"
        );
        $statement->execute([hash("sha256",$password),$email,$pseudo]);
        $response = $statement->fetch();

        if ($response) {
            //existe
            $this->cookie($email, $password);
            // session_start(); /*sinon on demarre la session*/
            // $_SESSION['email'] = $email;
            // $_SESSION['password'] = $password;
            // $_SESSION['logged'] = true;
		} else {
            //existe pas
        }  
    }

    public function register(string $email,string $pseudo, string $password){
        $prepareverif = $this->connexion->prepare(
            "SELECT `email`, `pseudo` FROM `user` WHERE `email`=:email AND `pseudo`=:pseudo"
        );
        $prepareverif->execute(["email" => $email, "pseudo" => $pseudo]);

        $response = $prepareverif->fetch();

        if ($response) {
            echo "non";
        } else {
            $prepareregister = $this->connexion->prepare(
                "INSERT INTO user(id_user, email, pseudo, `password`) VALUES (DEFAULT,:email,:pseudo,:password)"
            );
            $prepareregister->execute(['email' => $email, 'pseudo' => $pseudo, 'password' => hash("sha256",$password)]);
        }
    }

    public function cookie(string $email, string $password) {
        setcookie('email', $email);
        setcookie('password', $password);
    }
}

class friendList {

    public PDO $connexion;

    public function __construct(){
        $this->connexion = new PDO('mysql:host=localhost;dbname=social_network;charset=utf8', 'root', '');
    }

    public function searchFriend(string $friend) {
        $statement = $this->connexion->prepare(
            "SELECT id_user FROM `user` WHERE pseudo=?"
        );
        $statement->execute([$friend]);
        $response = $statement->fetch(PDO::FETCH_ASSOC);
        // var_dump($response);
        if ($response) {
            //envoie la demande au gars
            $id_user_2 = $response["id_user"];
            $prepareregister = $this->connexion->prepare(
                //récuper l'id user 1 via les sessions ou cookies
                "INSERT INTO `friends_list`(`id_request`, `id_user_1`, `id_user_2`, `status`) VALUES (DEFAULT, 1, :id_user_2, DEFAULT)"
            );
            $prepareregister->execute(['id_user_2' => $id_user_2]);
        } else {
            //la personne n'existe pas
        }
    }
}

// class friendList {

//     public function searchFriend(string $friend) {
//         $statement = $this->connexion->prepare(
//             "SELECT pseudo FROM user WHERE pseudo=?"
//         );
//         $statement->execute([$friend]);
//         $response = $statement->fetch();

//         if ($response) {
//             //envoie la demande au gars
//             $prepareregister = $this->connexion->prepare(
//                 //récuper l'id user 1 via les sessions ou cookies
//                 "INSERT INTO `friends_list`(`id_request`, `id_user_1`, `id_user_2`, `status`) VALUES (DEFAULT, '1','[value-3]','[value-4]')"
//             );
//             $sendregister = $prepareregister->execute(['email' => $email, 'pseudo' => $pseudo, 'password' => hash("sha256",$password)]);
//         } else {
//             //la personne n'existe pas
//         }
//     }
// }