<?php

namespace controllers;

// require "models/Meal.php";
use models\User;
use traits\SecurityController;

class UserController
{
    use SecurityController;
    private User $user;
    private string $_lastName;
    private string $_firstName;
    private string $_birthDay;
    private string $_birthMonth;
    private string $_birthYear;
    private string $_address;
    private string $_city;
    private int $_zipCode;
    private string $_phone;
    private string $_email;
    private string $_password;
    private string $_passwordVerif;
    private array $errors;
    
    public function __construct()
    {
        $this -> user = new User();
        $this->errors = [];
    }
    
    public function createUserPage():void
    {
        if (isset($_POST['submit']))
        {
            $this-> setFormDataFromPost();
            $errors = $this->getErrors();
            if(!$errors)
            {
                $errorTest = $this->user->addUser($this->getLastName(),$this->getFirstName(),$this->getBirthDay(),$this->getBirthMonth(),$this->getBirthYear(),$this->getAddress(),$this->getCity(),$this->getZipCode(),$this->getPhone(),$this->getEmail(),$this->getPassword(),$this->getPasswordVerif()); 
                if(is_string($errorTest) && !empty($errorTest) && isset($errorTest)){
                    $this->errors[] = $errorTest;
                    $errors = $this->getErrors();
                }
            }
            
        }
        $template = "users/createaccount";
        require "views/layout.phtml";
    }

    public function LoginUserPage():void
    {
        if (isset($_POST['submit']))
        {
            $this-> setFormDataFromPost();
            $errors = $this->getErrors();
            if(!$errors)
            {
                $this->loginUser($this->getEmail(),$this->getPassword()); 
                    $errors = $this->getErrors();   
            }
            
        }
        $template = "users/connexion";
        require "views/layout.phtml";
    }

    public function loginUser ($email, $password) {
        $testPassword = $this->user->checkEmailPassword($email);
        if($testPassword)
        {
            //verification similarité
            $testMDP = password_verify($password,$testPassword);
            $userId = $this->user->getUserId($this->getEmail());
            if ($testMDP) {
                $_SESSION['user'] = $userId;
                header("location:index.php?message=Vous êtes bien connecté avec l'adresse email $email");
                exit();  
            } else {
                $this->errors[] = "Le mot de passe ou email n'existe pas."; 
            }
                

        }
        else
        {
            $this->errors[] = "Le mot de passe ou email n'existe pas.";
        }
    }

    public function logOut() {
        if(isset($_SESSION['user']) || isset($_SESSION['admin']))
        {
            session_destroy();
            header("location:index.php");
        }
    }

    public function setFormDataFromPost() {
        $fields = [
            'lastName', 'firstName', 'birthDay', 'birthMonth', 'birthYear', 'address', 'city', 'zipCode', 'phone', 'email', 'password', 'passwordConfirm'
        ];

        foreach ($fields as $fieldName) {
            if (isset($_POST[$fieldName])) {
                $fieldValue = $_POST[$fieldName];
                switch ($fieldName) {
                    case 'lastName':
                        $this->setLastName($fieldValue);
                        break;
                    case 'firstName':
                        $this->setFirstName($fieldValue);
                        break;
                    case 'birthDay':
                        $this->setBirthDay($fieldValue);
                        break;
                    case 'birthMonth':
                        $this->setBirthMonth($fieldValue);
                        break;
                    case 'birthYear':
                        $this->setBirthYear($fieldValue);
                        break;
                    case 'address':
                        $this->setAddress($fieldValue);
                        break;
                    case 'city':
                        $this->setCity($fieldValue);
                        break;
                    case 'zipCode':
                        $this->setZipCode($fieldValue);
                        break;
                    case 'phone':
                        $this->setPhone($fieldValue);
                        break;
                    case 'email':
                        $this->setEmail($fieldValue);
                        break;
                    case 'password':
                        $this->setPassword($fieldValue);
                        break;
                    case 'passwordConfirm':
                        $this->setPasswordVerif($fieldValue);
                        break;
                    default:
                    break;
                }
            }
        }
    }

    public function getLastName(): string
    {
        return $this->_lastName;
    }

    public function getFirstName(): string
    {
        return $this->_firstName;
    }

    public function getBirthDay(): string
    {
        return $this->_birthDay;
    }

    public function getBirthMonth(): string
    {
        return $this->_birthMonth;
    }

    public function getBirthYear(): string
    {
        return $this->_birthYear;
    }

    public function getAddress(): string
    {
        return $this->_address;
    }

    public function getCity(): string
    {
        return $this->_city;
    }

    public function getZipCode(): int
    {
        return $this->_zipCode;
    }

    public function getPhone(): string
    {
        return $this->_phone;
    }

    public function getEmail(): string
    {
        return $this->_email;
    }

    public function getPassword(): string
    {
        return $this->_password;
    }

    public function getPasswordVerif(): string
    {
        return $this->_passwordVerif;
    }
    
    
    public function setLastName(string $lastName)
    {
        $regex = '/^[a-zA-Z- éèà]{3,50}$/u';
        
        if (empty($lastName) && !isset($lastName)) {
            $errorMessage = "Le champ 'lastName' ne peut pas être vide";
            $this->errors[] = $errorMessage;
        } elseif (!preg_match($regex, $lastName)) {
            $this->errors[] = "Le nom n'est pas valide";           
        } else {
            $this->_lastName = htmlspecialchars($lastName);     
        }
    }

    public function setFirstName(string $firstName)
    {
        $regex = "/^[a-zA-Z- éèà]{3,50}$/";
        if (empty($firstName) && !isset($firstName)) {
            $errorMessage = "Le champ 'firstname' ne peut pas être vide";
            $this->errors[] = $errorMessage;
        } elseif (!preg_match($regex, $firstName)) {
            $this->errors[] = "Le prénom n'est pas valide";          
        } else {
            $this->_firstName = htmlspecialchars($firstName);
        }
    }

    public function setBirthDay(string $birthDay)
    {
        $regex = '/^\d{2}$/';
        if (empty($birthDay) && !isset($birthDay)) {
            $errorMessage = "Le champ 'birthday' ne peut pas être vide";
            $this->errors[] = $errorMessage;
        // } elseif (!preg_match($regex, $birthDay)) {
        //     $this->errors[] = "Le jour de naissance n'est pas valide";         
        } else {
            $this->_birthDay = htmlspecialchars($birthDay);
        }
    }

    public function setBirthMonth(string $birthMonth)
    {
        $regex = '/^\d{2}$/';
        if (empty($birthMonth) && !isset($birthMonth)) {
            $errorMessage = "Le champ 'birthmonth' ne peut pas être vide";
            $this->errors[] = $errorMessage;
        // } elseif (!preg_match($regex, $birthMonth)) {
        //     $this->errors[] = "Le mois de naissance n'est pas valide";         
        } else {
            $this->_birthMonth = htmlspecialchars($birthMonth);
        }

    }

    public function setBirthYear(string $birthYear)
    {
        $regex = '/^\d{4}$/';
        if (empty($birthYear) && !isset($birthYear)) {
            $errorMessage = "Le champ 'birthyear' ne peut pas être vide";
            $this->errors[] = $errorMessage;
        // } elseif (!preg_match($regex, $birthYear)) {
        //     $errorMessage = "L'anné de naissance n'est pas valide";
        //     $this->errors[] = $errorMessage;         
        } else {
            $this->_birthYear = htmlspecialchars($birthYear);
        }
    }

    public function setAddress(string $address)
    {
        $regex = '/^[A-Za-z0-9\s\-\',.]+$/';
        if (empty($address) && !isset($address)) {
            $errorMessage = "Le champ 'adresse' ne peut pas être vide";
            $this->errors[] = $errorMessage;
        } elseif (!preg_match($regex, $address)) {
            $this->errors[] = "L'adresse n'est pas valide";         
        } else {
            $this->_address = htmlspecialchars($address);
        }
    }

    public function setCity(string $city)
    {
        $regex = '/^[A-Za-z\s\-\']+$/';
        if (empty($city) && !isset($city)) {
            $errorMessage = "Le champ 'city' ne peut pas être vide";
            $this->errors[] = $errorMessage;
        } elseif (!preg_match($regex, $city)) {
            $this->errors[] = "La ville n'est pas valide";         
        } else {
            $this->_city = htmlspecialchars($city);
        }
    }

    public function setZipCode(string $zipCode)
    {
        $regex = '/^\d{5}$/';

        if (empty($zipCode) && !isset($zipCode)) {
            $errorMessage = "Le champ 'zidcode' ne peut pas être vide";
            $this->errors[] = $errorMessage;
        }
        else if(!preg_match($regex,$zipCode))
        {
            $this->errors[] = "Le code postal n'est pas valide"; 
        }
        else
        {
            $this->_zipCode = intval($zipCode);
        }
        
    }

    public function setPhone(string $phone)
    {
        $regex = '/^\d{10}$/';
        

        if (empty($phone) && !isset($phone)) {
            $errorMessage = "Le champ 'phone' ne peut pas être vide";
            $this->errors[] = $errorMessage;
        }
        else if (!preg_match($regex,$phone))
        {
            $this->errors[] = "Le numéro de téléphone n'est pas valide"; 
        }
        else
        {
            $this->_phone = htmlspecialchars($phone);
        }
        
    }

    public function setEmail(string $email)
    {
        $regex = '/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/';

        if (empty($email) && !isset($email)) {
            $errorMessage = "Le champ 'phone' ne peut pas être vide";
            $this->errors[] = $errorMessage;
        }
        else if(!preg_match($regex,$email)){
            $this->errors[] = "L'addresse email n'est pas valide";
        }
        else
        {
            $this->_email = htmlspecialchars($email);
        }
    }

    public function setPassword(string $password)
    {
        $regex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#$%^&+=]).{8,}$/';
        if (empty($password) && !isset($password)) {
            $errorMessage = "Le champ 'phone' ne peut pas être vide";
            $this->errors[] = $errorMessage;
        }
        else if(!preg_match($regex,$password))
        {
            $this->errors[] = "Le mot de passe 1 n'est pas valide"; 
        }
        else
        {
            $this->_password = htmlspecialchars($password);
        }
        
    }

    public function setPasswordVerif(string $passwordVerif)
    {
        $regex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#$%^&+=]).{8,}$/';
        if (empty($passwordVerif) && !isset($passwordVerif)) {
            $errorMessage = "Le champ 'phone' ne peut pas être vide";
            $this->errors[] = $errorMessage;
        }
        else if(!preg_match($regex,$passwordVerif))
        {
            $this->errors[] = "Le mot de passe 2 n'est pas valide"; 
        }
        else
        {
            $this->_passwordVerif = htmlspecialchars($passwordVerif);
        }
        
    }

    public function getErrors() {
        if (empty($this->errors)) {
        return false;
        } else if(!empty($this->errors)) {
            return $this -> errors;
        }
    }
    
}