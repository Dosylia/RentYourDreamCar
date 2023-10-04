<?php
namespace models;

use config\DataBase;

class Admin extends DataBase
{
    private \PDO $bdd;
    
    public function __construct()
    {
        $this -> bdd = $this -> getBdd();
    }
 
    public function adminLogin($emailInput)
    {
        $query = $this -> bdd -> prepare("
                                            SELECT
                                                password
                                            FROM
                                                admin
                                            WHERE
                                                email = ?
        ");

        $query-> execute([$emailInput]);

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

}





