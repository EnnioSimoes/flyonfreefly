<?php

class LoginHelper
{
    public function checkLogin()
    {
        return isset($_SESSION['login']);
    }

    public function login($data)
    {
        $_SESSION['login'] = $data;
    }

    public function logout()
    {
        session_destroy();
    }

    public function getData()
    {
        return $_SESSION['login'];
    }
}
