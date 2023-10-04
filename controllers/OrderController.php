<?php

namespace controllers;

use models\Order;
use models\Meal;
use traits\SecurityController;

class OrderController
{
    use SecurityController;
    private Order $order;
    private Meal $meal;
    
    public function __construct()
    {
        $this -> order = new Order();
        $this -> meal = new Meal();
    }
    
    public function OrderPage():void
    {
        if($this->isConnect())
        {
            $orders = $this -> meal -> getProducts();
            $template = "order/order";
            require "views/layout.phtml";
        }else 
        {
            header("location:index.php?message=Vous devez être connecté");
            exit(); 
        }
        
    }

    public function displayProductData(){
        
            if(isset($_POST['id']))
            {
                $data  = $this -> meal-> getProductById($_POST['id']);
                header('Content-type: application/json');
                echo json_encode($data);
            }
            
    }

    public function newOrder() {
        
        if(isset($_POST['param']))
        {
            $data = json_decode($_POST['param']);
            // var_dump($data);

            if($data -> total <= 0) {
                return;
            }else
            {
                $status = $data -> status;
                $total = $data -> total;
                $user_id = $_SESSION['user'];
                $cart = json_decode($data -> cart);
                
                // var_dump($cart);
                $lastInsertID = $this->order->addOrder($status,$total,$user_id);
                // echo $lastInsertID;

                foreach($cart as $item)
                {
                    $result = $this->order->addOrderDetails($lastInsertID,$item -> codeProduit,$item -> quantite,$item -> prix);

                }
            }
            
            
            
        }
        
    }

    public function getOrders(){

        $orders = $this->order->getOrders();

        $template = "views/admin/listOrder";
        require "views/layout.phtml";

    }

    public function orderDetailsPage()
    {
        if($this ->isConnectAdmin())
        {
            if(isset($_GET['orderId'])) 
            {
                $orderId = intval($_GET['orderId']);
                $orderDetails = $this->order->getOrderDetails($orderId);
                $orders = $this->order->getOrderById($orderId);
                $template = "views/admin/listOrderDetails";
                require "views/layout.phtml";
            } else {
                header("location:index.php?action=listOrder&message=Contactez un Admin c'est la galère");
                exit();
            }
        }else 
        {
            header("location:index.php?message=Vous devez être admin.");
            exit(); 
        }
        



    }

}







