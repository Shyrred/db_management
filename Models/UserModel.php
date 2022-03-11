<?php

require_once "initDatabase.php";


/**
 * contains all the methods to interact with database (for users only)
 */

class UserModel extends Database
{
    /**
     * insert a new user in the database
     */

    public function sign_up($nom, $prenom, $email, $promotion): bool
    {

        $preReq = 'SELECT * FROM `projet_bdd`.utilisateurs WHERE Mail_User_Utilisateurs= :email';
        $stmt = $this->getDatabase()->prepare($preReq);
        $stmt->bindParam('email', $email);
        $stmt->execute();
        $response = $stmt->fetchAll(PDO::FETCH_OBJ);
        $stmt->closeCursor();

        if ($response) {
            return false;
        } else {

            $req = 'INSERT INTO `projet_bdd`.utilisateurs (Nom_User_Utilisateurs, Prenom_User_Utilisateurs, Promo_User_Utilisateurs, Mail_User_Utilisateurs) VALUES(:nom, :prenom, :promotion, :email)';
            $stmt = $this->getDatabase()->prepare($req);
            $stmt->bindParam('nom', $nom);
            $stmt->bindParam('prenom', $prenom);
            $stmt->bindParam('email', $email);
            $stmt->bindParam('promotion', $promotion);

            $response = $stmt->execute();
            $stmt->closeCursor();
            return $response;
        }
    }

//    /**
//     * verify if user's mail and password are correct
//     */
//    public function sign_in($email, $password)
//    {
//        $req = "SELECT Id_User_Utilisateurs from `projet_bdd`.utilisateurs WHERE Mail_User_Utilisateurs= :email and password_users= :password";
//        $stmt = $this->getDatabase()->prepare($req);
//
//        $stmt->bindParam('email', $email);
//        $stmt->bindParam('password', $password);
//
//        $stmt->execute();
//        $data = $stmt->fetch(PDO::FETCH_OBJ);
//        $stmt->closeCursor();
//        return $data;
//    }
}
