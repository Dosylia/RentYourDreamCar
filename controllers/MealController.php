<?php

namespace controllers;
use traits\SecurityController;
use models\Meal;

class MealController
{
    use SecurityController;
    private Meal $meal;
    
    public function __construct()
    {
        $this -> meal = new Meal();
    }
    
    public function home():void
    {
        $meals = $this -> meal -> getMeals();
        $template = "home";
        require "views/layout.phtml";
    }

    public function addMealPage()
    {
        if($this->isConnectAdmin())
        {
            if(isset($_POST['submit']))
            {
                $uploads_dir = "public/images/upload";

                if (!empty($_FILES['photo']['name'])) {
                    $tmp_name = $_FILES["photo"]["tmp_name"];
                    $name = $_FILES["photo"]["name"];
                    move_uploaded_file($tmp_name, "$uploads_dir/$name");
                }
                if (isset($_POST['ajout_nom']) && !empty($_POST['ajout_nom']) && isset($_POST['description']) && !empty($_POST['description']) && isset($_POST['prix_vente']) && !empty($_POST['prix_vente']))
                {
                    $productName = $_POST['ajout_nom'];
                    $productDesc = $_POST['description'];
                    $productPicture = $name;
                    $productPrice = $_POST['prix_vente'];
                } else {
                    header("location:index.php?action=addMeal&message=Les champs ne peuvent pas être vide.");
                    exit();                     
                }
                $this->meal->addMeal($productName,$productDesc,$productPicture,$productPrice);
                $template = "views/admin/admin";
                // header("location:index.php?action=admin&message=Produit ajouté");
                // exit();  
            }
            else
            {
                $template = "views/admin/addMeal"; 
            }
            require "views/layout.phtml";
        }
        else 
        {
            header("location:index.php?message=Vous devez être admin.");
            exit(); 
        }

            
            
    }



    public function modifMealPage():void
    {

            if($this ->isConnectAdmin()) 
            {
                    if(isset($_GET['idMeal'])) 
                    {
                        $idMeal = $_GET['idMeal'];
                        $meal = $this->meal->getProductById($idMeal);
                        $template = "views/admin/modifMealId";
                    }
                    else
                    {
                        $meals = $this -> meal -> getMeals();
                        $template = "views/admin/modifMeal";             
                    }
     
                } else {
                    header("location:index.php?message=Vous devez être admin.");
                    exit(); 
                }

            

            require "views/layout.phtml";    

    }

    public function modifMeal()
    {

        if($this ->isConnectAdmin())
        {
            if(isset($_POST['submit'])) {


                    $uploads_dir = "public/images/upload";
                if (!empty($_FILES['photo']['name'])) 
                {
                        $tmp_name = $_FILES["photo"]["tmp_name"];
                        $name = $_FILES["photo"]["name"];
                        move_uploaded_file($tmp_name, "$uploads_dir/$name");
                        $pictureToUse = $name;
                }
                else 
                {
                    $pictureToUse = $_POST['currentpic'];
                }

                if(isset($_POST['idMeal']) && !empty($_POST['idMeal']) && isset($_POST['ajout_nom']) && !empty($_POST['ajout_nom']) && isset($_POST['description']) && !empty($_POST['description']) && isset($_POST['prix_vente']) && !empty($_POST['prix_vente']))
                {
                    $idMeal = htmlspecialchars($_POST['idMeal']);
                    $productName = htmlspecialchars($_POST['ajout_nom']);
                    $productDesc = $_POST['description'];
                    $productPrice = $_POST['prix_vente'];
                }


                $this->meal->modifMeal($idMeal,$productName,$productDesc,$pictureToUse,$productPrice);
                $this->modifMealPAge();
            } else {
                header("location:index.php?message=Vous devez être admin.");
                exit(); 
            }                                                                                  
        }
        
    }

    

    public function deleteMeal()
    {

        if($this ->isConnectAdmin()) {
            if(isset($_GET['idMeal']))
            {
                $idMeal = intval($_GET['idMeal']);
                $this->meal->deleteMeal($idMeal);
                header("location:index.php?action=modifMeal&message=Le produit a été supprimé.");
                exit();
            } 
        } else {
            header("location:index.php?message=Vous devez être admin.");
            exit(); 
        }
    }

}