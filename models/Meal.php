<?php
namespace models;

use config\DataBase;

class Meal extends DataBase
{
    private \PDO $bdd;
    
    public function __construct()
    {
        $this -> bdd = $this -> getBdd();
    }
    
    public function getMeals(): ?array
    {
        $query = $this -> bdd -> prepare("
                                            SELECT
                                                `product_id`,
                                                `productName`,
                                                `productDesc`,
                                                `productPicture`,
                                                `productPrice`
                                            FROM
                                                `products`

                                         ");
        $query -> execute();
        $meals = $query -> fetchAll();
        
        return $meals;
    }
    
    public function getProductById($id) {

        $query = $this -> bdd -> prepare("
                                            SELECT
                                                `product_id`,
                                                `productName`,
                                                `productDesc`,
                                                `productPicture`,
                                                `productPrice`
                                            FROM
                                                `products`
                                            WHERE
                                                product_id = ?

                                         ");
        $query -> execute([$id]);
        $meal = $query -> fetch();
        
        return $meal;

    }

    public function getProducts() {
        
        $query = $this -> bdd -> prepare("
                                            SELECT
                                                `product_id`,
                                                `productName`,
                                                `productDesc`,
                                                `productPicture`,
                                                `productPrice`
                                            FROM
                                                `products`

                                         ");
        $query -> execute();
        $meals = $query -> fetchAll();
        
        return $meals;
    }

    // public function getNotTakenProduct($date) {
    
    //     $query = $this->bdd->prepare("
    //                                     SELECT
    //                                         p.product_id,
    //                                         p.productName,
    //                                         p.productDesc,
    //                                         p.productPicture,
    //                                         p.productPrice
    //                                     FROM
    //                                         products AS p
    //                                     WHERE
    //                                         p.product_id NOT IN (
    //                                             SELECT DISTINCT
    //                                                 od.productCode
    //                                             FROM
    //                                                 ordersdetails AS od
    //                                             INNER JOIN
    //                                                 orders AS o ON od.order_id = o.order_id
    //                                             INNER JOIN
    //                                                 booking AS b ON o.user_id = b.user_id
    //                                             WHERE
    //                                                 b.date = ?
    //                                         );
    //                                 ");
    //     $query->execute([$date]);
    //     $meals = $query->fetchAll();
        
    //     return $meals;
    // }

    public function addMeal($productName,$productDesc,$productPicture,$productPrice){

        $query = $this->bdd -> prepare("
                                        INSERT INTO products(
                                                `productName`,
                                                `productDesc`,
                                                `productPicture`,
                                                `productPrice`
                                        )
                                        VALUES(
                                            ?,
                                            ?,
                                            ?,
                                            ?
                                        )
        ");

        $test = $query->execute([$productName,$productDesc,$productPicture,$productPrice]);

    }

    public function modifMeal($productId,$productName,$productDesc,$productPicture,$productPrice){

        $query = $this->bdd->prepare("
                                        UPDATE 
                                            products
                                        SET
                                            productName = ?,
                                            productDesc = ?,
                                            productPicture = ?,
                                            productPrice = ?
                                        WHERE
                                            product_id = ?

        ");

        $test = $query->execute([$productName,$productDesc,$productPicture,$productPrice,$productId]);

    }

    public function deleteMeal($productId)
    {

        $query = $this->bdd->prepare("
                                    DELETE FROM
                                        products
                                    WHERE
                                        product_id = ?
        ");

        $success = $query->execute([$productId]);

        return $success;

    }

}




