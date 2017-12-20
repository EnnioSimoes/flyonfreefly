<?php

class LoginHelper
{
    public function checkLogin()
    {
        return isset($_SESSION['login']);
    }
}
