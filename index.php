<?php
session_start();
use controllers\MealController;
use controllers\UserController;
use controllers\OrderController;
use controllers\BookingController;
use controllers\AdminController;


function chargerClasse($classe)
{
    $classe=str_replace('\\','/',$classe);      
    require $classe.'.php'; 
}

spl_autoload_register('chargerClasse');


$userController = new UserController();
$mealController = new MealController();
$orderController = new orderController();
$bookingController = new BookingController();
$adminController = new AdminController();




if(isset($_GET["action"])) {
    switch($_GET["action"]){

        case "createAccount":
                $userController -> createUserPage(); 
        break;
        case "connexion":
            $userController -> LoginUserPage();
        break;
        case "deconnexion":
            $userController->logOut();
            break;
        case "order":
            $orderController->OrderPage();
            break;
        case "booking":
            $bookingController->BookingPage();
            break;
        case "orderAJAX":
            $orderController->displayProductData();
            break;
        case "orderInsert":
            $orderController->newOrder();
            break;
        case "admin":
            $adminController->adminPage();
            break;
        case "connexionAdmin":
            $adminController->adminLogin();
            break;
        case "addMeal":
            $mealController->addMealPage();
            break;
        case "modifMeal":
            $mealController->modifMealPage();
            break;
        case "formModifMeal" :
            $mealController->modifMeal();
            break;
        case "suppMeal" :
            $mealController->deleteMeal();
            break;
        case "listBooking":
            $bookingController->listBookingPage();
            break;
        case "listOrder":
            $orderController->getOrders();
            break;
        case "listOrderDetails":
            $orderController->orderDetailsPage();
            break;
        default:
            $mealController -> home(); 
        break;
    
    }
} else {
    $mealController -> home(); 
}
