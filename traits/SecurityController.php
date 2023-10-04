<?php

namespace traits;

trait SecurityController
{
    public function isConnect()
    {
        if(isset($_SESSION['user']))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function isConnectAdmin() 
    {
        if(isset($_SESSION['admin']))
        {
            return true;
        }
        else
        {
            return false;
        }

    }
}