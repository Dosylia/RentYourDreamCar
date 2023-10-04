<?php

namespace controllers;
use traits\SecurityController;
use models\Admin;

class AdminController
{
    use SecurityController;
    private Admin $admin;
    
    public function __construct()
    {
        $this -> admin = new Admin();
    }
    
    public function adminPage():void
    {
        $template = "admin/admin";
        require "views/layout.phtml";
    }

    public function adminLogin()
    {

        if(isset($_POST['submit']))
        {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $passwordHash =$this->admin->adminLogin($email);
    
            if($passwordHash) {
                $testMDP = password_verify($password,$passwordHash); 
                if ($testMDP) {
                    $_SESSION['admin'] = $email;
                    header("location:index.php?action=admin&message=Vous êtes bien connecté en tant qu'administrateur avec l'adresse email $email");
                    exit();  
                } else {
                    header("location:index.php?action=admin&message=Votre mot de passe ou email est invalide");
                    exit();  
                }
            } else {
                header("location:index.php?action=admin&message=Votre mot de passe ou email est invalide");
                exit();  
            }

        }

    }
}