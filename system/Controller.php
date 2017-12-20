<?php

class Controller
{
    public $request;

    public function __construct()
    {
        $this->request = new RequestHelper();
    }

    protected function goToAction($action)
    {
        global $System;

        if ($action) header('location: ' . _PATH_ . $System->getController() . '/' . $action);
        else header('location: ' . _PATH_ . $System->getController());
        exit;
    }

    protected function view($path)
    {
        if (file_exists(_DIR_VIEWS_ . $path . '.html')) include _DIR_VIEWS_ . $path . '.html';
        else if (file_exists(_DIR_VIEWS_ . $path . '.php')) include _DIR_VIEWS_ . $path . '.php';
        else die('View nao encontrada');
    }
}
