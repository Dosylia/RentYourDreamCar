<?php

// lance la connexion à la BDD 
namespace config;

class DataBase
{
    private const SERVER = "localhost";
    private const DB = "emmamontbarbon_restaurent";
    private const USER = "root";
    private const MDP = "root";
    private const PORT = "3306";
    
    private \PDO $bdd; 
    
    public function getBdd(): ? \PDO
    {
        try
        {
            $this -> bdd = new \PDO('mysql:host='.self::SERVER.';dbname='.self::DB.';charset=utf8', self::USER, self::MDP, array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));
        }
        catch(\Exception $message)
        {
            die('Le message d\'erreur de connexion BDD : '.$message -> getMessage());
        }
 
        return $this -> bdd;
    }
}
// tester 
// $bdd = new DataBase();
// var_dump($bdd -> getBdd());






