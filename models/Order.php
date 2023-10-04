<?php
namespace models;

use config\DataBase;

class Order extends DataBase
{
    private \PDO $bdd;
    
    public function __construct()
    {
        $this -> bdd = $this -> getBdd();
    }  

    public function addOrder($status,$total,$user_id) {
        
        $query = $this->bdd->prepare("
                                            INSERT INTO orders (
                                                orderDate,
                                                status,
                                                total,
                                                user_id
                                            )
                                            VALUES (
                                            NOW(),
                                            ?,
                                            ?,
                                            ?
                                            )"
                                    );

        $test = $query->execute([$status,$total,$user_id]);
        
        if($test)
        {
            return $this->bdd-> lastInsertId();
        }
        // return $test;

    }

    public function getOrderIdByDate($orderDate){

        $query = $this->bdd->prepare("
                                        SELECT
                                            order_id
                                        FROM
                                            orders
                                        WHERE
                                            date = ?
        ");

        $query->execute($orderDate);
        $orderId = $query->fetch();
        return $orderId;
    }
    
     public function addOrderDetails($orderId,$product_id,$quantity,$priceEach){

        $query = $this->bdd->prepare(
            "
                                            INSERT INTO ordersdetails (
                                                order_id,
                                                productCode,
                                                quantity,
                                                priceEach
                                            )
                                            VALUES (
                                            ?,
                                            ?,
                                            ?,
                                            ?
                                            )"
                                            );

        $test = $query->execute([$orderId,$product_id,$quantity,$priceEach]);
        
        return $test;
    }

    public function getOrders(){

        $query = $this->bdd->prepare("
                                        SELECT
                                            o.order_id,
                                            o.orderDate,
                                            o.status,
                                            o.total,
                                            o.user_id,
                                            u.nom,
                                            u.prenom
                                        FROM
                                            orders AS o
                                        INNER JOIN
                                            users AS u
                                        ON
                                            o.user_id = u.user_id
        ");

        $query->execute();

        $orders = $query->fetchAll();

        return $orders;
    }

    public function getOrderDetails($orderId)
    {
        $query = $this->bdd->prepare("
                                        SELECT
                                            od.order_id,
                                            od.quantity,
                                            od.priceEach,
                                            p.productName
                                        FROM
                                            ordersdetails as od
                                        INNER JOIN
                                            products as p
                                        ON 
                                            p.product_id = od.productCode
                                        WHERE
                                            od.order_id = ?
        ");

        $test = $query->execute([$orderId]);
        $orderDetails = $query->fetchAll();
        return $orderDetails;

    }

    public function getOrderById($orderId){

        $query = $this->bdd->prepare("
                                        SELECT
                                            o.order_id,
                                            o.orderDate,
                                            o.status,
                                            o.total,
                                            o.user_id,
                                            u.nom,
                                            u.prenom
                                        FROM
                                            orders AS o
                                        INNER JOIN
                                            users AS u
                                        ON
                                            o.user_id = u.user_id
                                        WHERE
                                            o.order_id = ?
        ");

        $query->execute([$orderId]);

        $orders = $query->fetch();

        return $orders;

    }
    
}



