<?php

// création d'une session
session_start();

//--------------------------------------------------------------------------------
//------------------------MODIFIER ET FONCTIONNEL---------------------------------
//--------------------------------------------------------------------------------


class bdd {
 //variable de connexion a la bdd
 public PDO $connexion;

    
 // fonction constructeur qui permet de connecter a la bdd
 public function __construct(){
     $this->connexion = new PDO('mysql:host=localhost;dbname=social_network;charset=utf8mb4', 'root', '');
 }    
}


//class en interaction avec les donées utilisateurs
class user extends bdd{

    //fonction qui permet d'envoyer n'importe quelle requete
    public function request(string $rqsql, array $exec): object{
        $statement = $this->connexion->prepare($rqsql);
        $statement->execute($exec);

        return $statement;
    }

    //fonction qui permet de récuprer des infos sans arguments
    public function info(string $rqsql): object{
        $statement = $this->connexion->prepare($rqsql);
        $statement->execute();
    
        return $statement;
    }

    //fonction qui renvoie un tableau avec les infos du user
    public function infoUser(string $id): array{
        $statement = $this->connexion->prepare(
            "SELECT * FROM `user` WHERE id_user= :id_user"
        );
        $statement->execute(['id_user' => $id]);
        $response = $statement->fetch();
        return $response;
    }    

    //----------------------------------------------------------------------------------------------------------------------------------------------------------
    //fonction qui permet de verifier lors de la creation d'un compte si l'utilisateur existe deja
    public function verif(string $email, string $pseudo):string{
        $verif = $this->request("SELECT `email`, `pseudo` FROM `user` WHERE `email`=:email OR `pseudo`=:pseudo", ["email" => $email, "pseudo" => $pseudo])->fetch();

        if ($verif) {
            if ($verif['email'] == $email && $verif['pseudo'] == $pseudo) {
                return "Ce pseudo et cet email sont deja attribués a un compte";
            } elseif ($verif['email'] == $email) {
                return "Cet email est deja attribué a un compte";
            } elseif ($verif['pseudo'] == $pseudo) {
                return "Ce pseudo est deja attribué a un compte";
            }
        }else{
            return "";
        }
    }

    //fonction qui permet d'enregistrer un utilisateur
    public function register(string $email,string $pseudo, string $password){
            $rqregister = $this->request("INSERT INTO user(id_user, email, pseudo, `password`) VALUES (DEFAULT,:email,:pseudo,:password)",['email' => $email, 'pseudo' => $pseudo, 'password' => hash("sha256",$password)]);
            $session = $this->request("SELECT `id_user` FROM `user` WHERE `email`=:email", ["email" => $email])->fetch();
            $_SESSION['id_user'] = $session['id_user'];
            $this->log($_SERVER['REMOTE_ADDR']." à créer un compte avec comme pseudo ".$pseudo);
    }

    //----------------------------------------------------------------------------------------------------------------------------------------------------------
    //fonction qui permet de se connecter
    public function login(string $email, string $pseudo, string $password) :bool
    {
        $statement = $this->request("SELECT id_user, email, pseudo, `password` FROM user WHERE password=:password AND (email=:email OR pseudo=:pseudo)", ['password' => hash("sha256",$password), 'email' => $email, 'pseudo' => $pseudo]);

        $response = $statement->fetch(PDO::FETCH_ASSOC);

        if ($response) {
            // création d'une variable pour stocker l'id
            $_SESSION['id_user'] = $response['id_user'];
            $this->log($_SERVER['REMOTE_ADDR']." s'est connecté en tant que ".$pseudo);
            return true;
		} else {
            //existe pas
            $this->log($_SERVER['REMOTE_ADDR']." n'as pas réussi à se connecté en tant que ".$pseudo);
            return false;
        }  
    }






    //----------------------------------------------------------------------------------------------------------------------------------------------------------
    //fonction qui permet d'afficher les settings
    public function getSettings() :array {
        $statement = $this->request("SELECT `email`, `pseudo`, `password` FROM `user` WHERE id_user= :id_user",['id_user' => $_SESSION['id_user']]);
        $response = $statement->fetchAll();
        return $response;
    }


    public function verifPassword(string $p1, string $p2, string $p3):string
    {
        $verif = $this->request("SELECT `password` FROM `user` WHERE id_user= :id_user",['id_user' => $_SESSION['id_user']])->fetch();

        if (hash("sha256",$p1) != $verif['password']) {

            return "L'ancien mot de passe ne correspond pas à l'actuel !";
        } else {

            if($p2 != $p3){

                return "Veuillez ecrire 2 fois le nouveau mot de passe !";

            } else {

                return "";

            }
        }
    }

    //fonction qui permet de changer le mot de passe
    public function changeMdp(string $password) {
        $mdp = hash("sha256",$password);

        $this->request("UPDATE `user` SET`password`=:password WHERE `id_user`=:id_user",['password' => hash("sha256",$password), 'id_user' => $_SESSION['id_user']]);
    }

    //fonction qui permet de supprimer un utilisateur (rajout de la suppr de img et session)
    public function deleteAccount() {
        unlink('../upload/'.$_SESSION['id_user'].'.png');
        $statement = $this->request("DELETE FROM `user` WHERE id_user= :id_user",['id_user' => $_SESSION['id_user']]);
        session_destroy();
    }


    //----------------------------------------------------------------------------------------------------------------------------------------------------------

    public function image(string $email) {
        $response = $this->request("SELECT `id_user`, `email` FROM `user` WHERE `email`=:email",["email" => $email])->fetch(PDO::FETCH_ASSOC);

            $tmpName = $_FILES['file']['tmp_name'];
            $name = $response['id_user'].".png";
            move_uploaded_file($tmpName, '../upload/'.$name);
    }


    public function changeImg(string $tmpName) {
        $name = $_SESSION['id_user'].".png";
        move_uploaded_file($tmpName, '../upload/'.$name);
    }


    //deconnection (rajout)
    public function disconnect()
    {
        $this->log($_SERVER['REMOTE_ADDR']." s'est déconnecté en tant que ");
        session_destroy();
    }

    public function log(string $log){
        date_default_timezone_set('Europe/Paris');
        $texte = file_get_contents('../Logs/log_task.txt');
        $texte .= "\n".$log." à ".date('d/m/Y H:i:s');
        file_put_contents('../Logs/log_task.txt',$texte);
    }

}



//--------------------------------------------------------------------------------
//--------------------------------------------------------------------------------
//--------------------------------------------------------------------------------


class comment extends user{

    public function createComment(string $idpost, string $message)
    {
        $this->request("INSERT INTO `date`(`id_comment`, `id_user`, `id_publication`, `message`, `date`) VALUES (DEFAULT,:id_user,:id_post,:message,NOW())",["id_user" => $_SESSION['id_user'], "id_post" => $idpost, "message" =>$message]);
    }

    public function getComments(string $idpost):array
    {
        return $this->request("SELECT user.id_user, user.pseudo,id_comment, `message`,`date` FROM `date` INNER JOIN user ON user.id_user=date.`id_user` WHERE`id_publication`=:id_post;",['id_post' => $idpost])->fetchAll();
    }

    public function deleteComment(string $idcomment)
    {
        $this->request("DELETE FROM `date` WHERE `id_comment`=:id_comment",['id_comment'=>$idcomment]);
    }


}



//class en interaction avec la table post
class post extends user {

    //fonction qui permet d'ajouter un post (ajouter emoji)
    public function createPost(string $message){
        $this->request("INSERT INTO `publication`(`id_publication`, `id_user`, `message`, `date`) VALUES (DEFAULT, :id_user ,:message,NOW())",["id_user"=>$_SESSION['id_user'],'message'=>$message]);
    }

    //fonction qui permet d'afficher tous les posts (GOOD)
    public function affichage(): array{
        return $this->request("SELECT publication.id_publication, publication.message, user.id_user, user.pseudo, publication.date FROM `publication` INNER JOIN user ON publication.id_user = user.id_user;",[])->fetchAll();
    }

    public function deletePost(string $idpost)
    {
        $this->request("DELETE FROM `date` WHERE `id_publication`=:id_publication",['id_publication'=>$idpost]);
        $this->request("DELETE FROM `publication` WHERE `id_publication`=:id_post",['id_post'=>$idpost]);
    }

    public function feed(int $debut, int $nbelem): array {
        return $this->request("SELECT pseudo, id_publication, publication.id_user, message, publication.date FROM publication INNER JOIN friends_list INNER JOIN user ON user.id_user=publication.id_user WHERE friends_list.status=1 AND friends_list.id_user_1=publication.id_user AND friends_list.id_user_2=:id_user OR friends_list.status=1 AND friends_list.id_user_2=publication.id_user AND friends_list.id_user_1=:id_user ORDER BY date DESC LIMIT $debut, $nbelem;",['id_user'=>$_SESSION['id_user']])->fetchAll();
    }

    public function count(): array {
        return $this->info("SELECT COUNT(*) FROM `publication`;")->fetch();
    }

}





























//class en interaction avec la table friend
class friendList {

    //variable de connexion a la bdd
    public PDO $connexion;

    //fonction constructeur qui permet de connecter a la bdd
    public function __construct(){
        $this->connexion = new PDO('mysql:host=localhost;dbname=social_network;charset=utf8mb4', 'root', '');
    }

    //fonction qui permet de rechercher un utilisateur et de le demander en amis
    public function searchFriend(string $friend):string {
        $statement = $this->connexion->prepare(
            "SELECT id_user FROM `user` WHERE pseudo=:pseudo"
        );
        $statement->execute(["pseudo"=>$friend]);
        $response = $statement->fetch(PDO::FETCH_ASSOC);
        //var_dump($response);
        if ($response) {
            if ($_SESSION["id_user"] != $response["id_user"]) {
                $statement = $this->connexion->prepare(
                    "SELECT * FROM `friends_list` WHERE `id_user_1`=:id_user_1 AND `id_user_2`=:id_user_2 OR `id_user_1`=:id_user_2 AND `id_user_2`=:id_user_1"
                );
                $statement->execute(["id_user_1" => $_SESSION["id_user"], "id_user_2" => $response["id_user"]]);
                $rep = $statement->fetch();
                if (!$rep) {
                    //envoie la demande au gars
                    $id_user_1 = $_SESSION["id_user"];
                    $id_user_2 = $response["id_user"];

                    $prepareregister = $this->connexion->prepare(
                        "INSERT INTO `friends_list`(`id_request`, `id_user_1`, `id_user_2`, `status`) VALUES (DEFAULT, :id_user_1, :id_user_2, DEFAULT)"
                    );
                    $prepareregister->execute(['id_user_1' => $id_user_1, 'id_user_2' => $id_user_2]);
                    return "demande d'amis envoyée";
                } else {
                    return "requette d'amis déjà envoyée";
                }
            } else {
                return "vous ne pouvez pas vous ajouter vous même en amis";
            }
        } else {
            return "la personne n'existe pas";
        }
    }

    //fonction qui permet d'afficher la liste d'amis
    public function friendList():array {
        //récupère l'id des deux amis
        $statement = $this->connexion->prepare(
            "SELECT user.pseudo, user.id_user, friends_list.id_request FROM friends_list INNER JOIN user ON friends_list.id_user_2=user.id_user WHERE friends_list.id_user_1=:id_user AND friends_list.status=1 UNION SELECT user.pseudo, user.id_user, friends_list.id_request FROM friends_list INNER JOIN user ON friends_list.id_user_1=user.id_user WHERE friends_list.id_user_2=:id_user AND friends_list.status=1;"
        );
        $statement->execute(['id_user' => $_SESSION['id_user']]);
        $response = $statement->fetchAll();
        return $response;
    }

    //fonction qui permet d'afficher les demandes d'amis reçus
    public function friendsReceive():array {
        $statement = $this->connexion->prepare(
            "SELECT user.pseudo, friends_list.id_request FROM friends_list INNER JOIN user ON friends_list.id_user_1=user.id_user WHERE id_user_2=:id_user_2 AND friends_list.status=0"
        );
        $statement->execute(['id_user_2' => $_SESSION['id_user']]);
        $response = $statement->fetchAll();
        return $response;
    }

    //fonction qui affiche toutes les demandes d'amis envoyés par l'utilisateur et qui sont en attente
    public function friendsRequest():array {
        $statement = $this->connexion->prepare(
            "SELECT user.pseudo, friends_list.id_request FROM friends_list INNER JOIN user ON friends_list.id_user_2=user.id_user WHERE id_user_1=:id_user_1 AND friends_list.status=0  "
        );
        $statement->execute(['id_user_1' => $_SESSION['id_user']]);
        $response = $statement->fetchAll();
        return $response;
    }

    public function responseRequest(string $rep, string $id) {
        if ($rep=="Accepter") {
            $statement = $this->connexion->prepare(
                "UPDATE friends_list SET status='1' WHERE id_request=:id_request"
            );
            $statement->execute(['id_request' => $id]);
            $response = $statement->fetchAll();
            return $response;
        } else {
            $statement = $this->connexion->prepare(
                "DELETE FROM friends_list WHERE id_request=:id_request"
            );
            $statement->execute(['id_request' => $id]);
            $response = $statement->fetchAll();
            return $response;
        }
        
    }

}

//class security redirect
class security {

    public function secure() {
        if ( $_SESSION['id_user'] == null) {
            header("Location: ../Controllers/login.php");
        }
    }

}