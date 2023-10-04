<?php
namespace models;

use config\DataBase;

class Booking extends DataBase
{
    private \PDO $bdd;
    
    public function __construct()
    {
        $this -> bdd = $this -> getBdd();
    }

    public function addBooking($date,$nbrPeople,$user_id){

        $query = $this->bdd->prepare("
                                            INSERT INTO booking (
                                                date,
                                                nbrPeople,
                                                user_id
                                            )
                                            VALUES (
                                            ?,
                                            ?,
                                            ?
                                            )"
                                    );

        $test = $query->execute([$date,$nbrPeople,$user_id]);

        if ($test)
        {
            return $this->bdd-> lastInsertId();
        } 
        else
        {
            return false;
        }

    }

    function getBooking(){

        $query = $this->bdd->prepare("
                                        SELECT
                                            b.date,
                                            b.nbrPeople,
                                            b.user_id,
                                            u.nom,
                                            u.prenom,
                                            u.telephone,
                                            u.email
                                        FROM
                                            booking AS b
                                        INNER JOIN
                                            users as u
                                        ON
                                            b.user_id = u.user_id
        ");

        $query->execute();

        $bookings = $query->fetchAll();

        return $bookings;
    }
    
}




