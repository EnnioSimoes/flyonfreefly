<?php

class RequestHelper
{
    public function get($name)
    {
        if (isset($_GET[$name])) return $_GET[$name];
        return null;
    }

    public function post($name)
    {
        if (isset($_POST[$name])) return $_POST[$name];
        return null;
    }

    public function server($name)
    {
        if (isset($_SERVER[$name])) return $_SERVER[$name];
        return null;
    }

    public function param($name)
    {
        global $System;
        $params = $System->getParams();
        if (isset($params[$name])) return $params[$name];
        return null;
    }
}
