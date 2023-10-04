<?php

namespace controllers;
use traits\SecurityController;
use models\Booking;

class BookingController
{
    use SecurityController;
    private Booking $booking;
    private string $_dateResa;
    private string $_bookingHour;
    private string $_bookingMin;
    private int $_nbCouverts;
    
    
    public function __construct()
    {
        $this -> booking = new Booking();
    }
    
    public function BookingPage():void
    {
        if($this -> isConnect())
        {
            $this->setFormDataFromPost();
            if(isset($_POST['submit'])) 
            {
                $test = $this->booking-> addBooking($this->getDate(),$this->getNbCouverts(),$_SESSION['user']);
                
                if($test)
                {
                    header("location:index.php?action=order&message=Votre réservation pour le ". $this->getDate() ." a bien été prise en compte, Selectionnez le modèle&bookingId=".$test."&date=".$this->getDate());
                    exit();  
                } else {
                    header("location:index.php?action=booking&message=La requète serveur a echouée");
                    exit();
                }
            }
            $template = "booking/booking";
            require "views/layout.phtml";
        }
        else 
        {
            header("location:index.php");
            exit();
        }
    }

    public function setFormDataFromPost() {
        $fields = [
            'dateResa', 'bookingHour', 'bookingMin', 'nbCouverts'
        ];

        foreach ($fields as $fieldName) {
            if (isset($_POST[$fieldName])) {
                $fieldValue = $_POST[$fieldName];
                switch ($fieldName) {
                    case 'dateResa':
                        $this->setDateResa($fieldValue);
                        break;
                    case 'bookingHour':
                        $this->setBookingHour($fieldValue);
                        break;
                    case 'bookingMin':
                        $this->setBookingMin($fieldValue);
                        break;
                    case 'nbCouverts':
                        $this->setNbCouverts($fieldValue);
                        break;
                    default:
                    break;
                }
            }
        }
    }

    public function getDateResa() : string
    {
        return $this->_dateResa;
    }

    public function getBookingHour() : string
    {
        return $this->_bookingHour;
    }

    public function getBookingMin() : string
    {
        return $this->_bookingMin;        
    }

    public function getNbCouverts() : int
    {
        return $this->_nbCouverts;
    }

    public function getDate() : string
    {
        return $this->getDateResa()." ".$this->getBookingHour().":".$this->getBookingMin();
    }

    public function setDateResa($dateResa)
    {
        $this->_dateResa = $dateResa;
    }

    public function setBookingHour($bookingHour)
    {
        $this->_bookingHour = $bookingHour; 
    }

    public function setBookingMin($bookingMin)
    {
        $this->_bookingMin = $bookingMin;   
    }

    public function setNbCouverts($nbCouverts)
    {
        $this->_nbCouverts = $nbCouverts;        
    }

    public function listBookingPage()
    {

        $bookings = $this->booking->getBooking();
        $template = "views/admin/listBooking";
        require "views/layout.phtml";    

    }

}