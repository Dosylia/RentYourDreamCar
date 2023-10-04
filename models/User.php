<?php
namespace models;

use config\DataBase;

class User extends DataBase
{
    private \PDO $bdd;
    private string $errors;

    
    public function __construct() {
        $this->bdd = $this->getBdd();
        $this->errors = "";
    }


    public function addUser($lastName, $firstName, $birthDay, $birthMonth, $birthYear, $address, $city,$zipCode, $phone, $email, $password, $verifPassword) {
        $currentMail = $email;
        $testmail = $this->getUserByEmail($currentMail);
        if (!$testmail)
        {

            if($password == $verifPassword) {
                $password = password_hash($password,PASSWORD_DEFAULT);

                $fullBirthDate = $birthDay . "/" . $birthMonth . "/" . $birthYear;

                $query =  $this -> bdd -> prepare("
                                        INSERT INTO `users`(
                                            `nom`,
                                            `prenom`,
                                            `dateNaissance`,
                                            `adresse`,
                                            `ville`,
                                            `codePostal`,
                                            `telephone`,
                                            `email`,
                                            `password`
                                        )
                                        VALUES(
                                            ?,
                                            ?,
                                            ?,
                                            ?,
                                            ?,
                                            ?,
                                            ?,
                                            ?,
                                            ?
                                        )
                                        ");
                // 2- exécuter la requete 
                $test = $query -> execute(
                    [$lastName,
                    $firstName,
                    $fullBirthDate,
                    $address,
                    $city,
                    $zipCode,
                    $phone,
                    $email,
                    $password]
                );
                //var_dump($test);
                if($test)
                {
                    header("location:index.php?action=connexion&message=Votre compte à bien été crée ");
                    exit();
                } else {
                    return "Contactez un admin";
                }
            } else {
                return "Les mot de passe ne vont pas ensemble.";
            }
        } else {
            return "L'email existe déjà.";
        }


        
        
    }
    
    public function getUserByEmail($currentMail)
    {
        $query = $this -> bdd -> prepare("
                                            SELECT
                                                `email`
                                            FROM
                                                `users`
                                            WHERE
                                                `email` = ?

                                         ");
        $test = $query -> execute([$currentMail]);
        if($test)
        {
            $user = $query->fetch();
            return $user;
        }
        else
        {
            return false;
        }
    }

    public function checkEmailPassword($currentMail)
    {
        $query = $this -> bdd -> prepare("
                                            SELECT
                                                `password`
                                            FROM
                                                `users`
                                            WHERE
                                                `email` = ?

                                         ");
        $test = $query -> execute([$currentMail]);
        $password = $query->fetch();
        if($password)
        {
            return $password['password'];
        }
        else
        {
            return false;
        }
    }

    public function getUserId($currentMail){
        $query = $this -> bdd -> prepare("
                                            SELECT
                                                `user_id`
                                            FROM
                                                `users`
                                            WHERE
                                                `email` = ?

                                         ");
        $test = $query -> execute([$currentMail]);
        $userId = $query->fetch();
        if($userId)
        {
            return $userId['user_id'];
        }
        else
        {
            return false;
        }
    }


}