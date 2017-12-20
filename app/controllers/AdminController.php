<?php

class AdminController extends Controller
{
    private function checkLogin()
    {
        $LoginHelper = new LoginHelper();
        $has_login = $LoginHelper->checkLogin();
        if (!$has_login) $this->goToAction('login');
    }

	public function indexAction()
	{
        $this->checkLogin();
		printa('ok');
	}

	public function loginAction()
	{
        $this->view('admin/login');
	}
}
