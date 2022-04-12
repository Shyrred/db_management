<?php

require_once "DatabaseModel.php";


/**
 * contains all the methods to interact with database (for users only)
 */

class UserModel extends Database
{
    /**
     * insert a new user in the database
     */

    public function sign_up($nom, $prenom, $email, $promotion, $password): bool //true if user is signed up in DB (doesn't already have an account)
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

            $req = 'INSERT INTO `projet_bdd`.utilisateurs (Nom_User_Utilisateurs, Prenom_User_Utilisateurs, Promo_User_Utilisateurs, Mail_User_Utilisateurs, Password_User) VALUES(:nom, :prenom, :promotion, :email, :password)';
            $stmt = $this->getDatabase()->prepare($req);
            $stmt->bindParam('nom', $nom);
            $stmt->bindParam('prenom', $prenom);
            $stmt->bindParam('email', $email);
            $stmt->bindParam('promotion', $promotion);
            $stmt->bindParam('password', $password);

            $response = $stmt->execute();
            $stmt->closeCursor();
            return $response;
        }
    }

    /**
     * verify if user's mail and password are correct
     */
    public function sign_in($email, $password) //true if logged in successfully
    {
        $req = "SELECT Password_User from `projet_bdd`.utilisateurs WHERE Mail_User_Utilisateurs= :email";
        $stmt = $this->getDatabase()->prepare($req);

        $stmt->bindParam('email', $email);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC); //retourne la case demandée : (sql query) {array -> Password_User['password']}
        $stmt->closeCursor();

        $check = false;
        if (password_verify($password, $data['Password_User'])) {
            $check = true;
        }
        return $check;ss
    }
}
