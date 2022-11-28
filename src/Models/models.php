<?php

// création d'une session
session_start();

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


    public function login(string $email, string $pseudo, string $password) :bool
    {
        $statement = $this->connexion->prepare(
            "SELECT id_user, email, pseudo, `password` FROM user WHERE password=? AND email=? OR pseudo=?"
        );
        $statement->execute([hash("sha256",$password), $email, $pseudo]);
        $response = $statement->fetch(PDO::FETCH_ASSOC);

        if ($response) {
            // création d'une variable pour stocker l'id
            $_SESSION['id_user'] = $response['id_user'];
            return true;
		} else {
            //existe pas
            return false;
        }  
    }

    public function register(string $email,string $pseudo, string $password){
        $prepareverif = $this->connexion->prepare(
            "SELECT `email`, `pseudo` FROM `user` WHERE `email`=:email AND `pseudo`=:pseudo"
        );
        $prepareverif->execute(["email" => $email, "pseudo" => $pseudo]);

        $response = $prepareverif->fetch();

        if ($response) {
            echo "ce compte existe déjà";
        } else {
            $prepareregister = $this->connexion->prepare(
                "INSERT INTO user(id_user, email, pseudo, `password`) VALUES (DEFAULT,:email,:pseudo,:password)"
            );
            $prepareregister->execute(['email' => $email, 'pseudo' => $pseudo, 'password' => hash("sha256",$password)]);
        }
    }

    function httpPost($url, $data){
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        echo $response;
    }

    // public function session(string $response) {
    //     $_SESSION['id_user'] = $response['id_user'];
    //     $varsess = $_SESSION['id_user'];
    // }
    
    public function settings() :array {
        $statement = $this->connexion->prepare(
            "SELECT `email`, `pseudo`, `password` FROM `user` WHERE id_user= :id_user"
        );
        $statement->execute(['id_user' => $_SESSION['id_user']]);
        $response = $statement->fetch();
        if ($response) {
            // $email = $response["email"];
            // $pseudo = $response["pseudo"];
            // $password = $response["password"];
            return $response;
        } else {
            //la personne n'existe pas
        }
    }

    public function changeMdp(string $password,string $password1, string $password2) {
        $statement = $this->connexion->prepare(
            "SELECT `password` FROM `user` WHERE password= :password"
        );
        $mdp = hash("sha256",$password);
        $statement->execute(['password' => $mdp]);
        $response = $statement->fetch();
        
        if ($response) {
            if ($password1 == $password2) {
                $prepare = $this->connexion->prepare(
                    "UPDATE `user` SET`password`=:password WHERE `id_user`=:id_user"
                );
                $prepare->execute(['password' => hash("sha256",$password1), 'id_user' => $_SESSION['id_user']]);
                echo "le mdp a bien été changé";
            } else {
                //les 2 mdp sont differents
                echo "les 2 mdp sont differents";
            }
        } else {
            //le mot de passe n'est pas bon
            echo "le mot de passe n'est pas bon";
        }
    }

    public function deleteAccount() {
        $statement = $this->connexion->prepare(
            "DELETE FROM `user` WHERE id_user= :id_user"
        );
        $statement->execute(['id_user' => $_SESSION['id_user']]);
        $statement->fetch();
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
            $id_user_1 = $_SESSION["id_user"];
            $id_user_2 = $response["id_user"];

            $prepareregister = $this->connexion->prepare(
                "INSERT INTO `friends_list`(`id_request`, `id_user_1`, `id_user_2`, `status`) VALUES (DEFAULT, :id_user_1, :id_user_2, DEFAULT)"
            );
            $prepareregister->execute(['id_user_1' => $id_user_1, 'id_user_2' => $id_user_2]);
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