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
        printa('admin ok');
        echo '<a href="' . _PATH_ . 'admin/logout' . '">logout</a>';
	}

	public function loginAction()
	{
        $this->view('admin/login', [
            'path' => _PATH_,
        ]);
	}

	public function loginPostAction()
	{
        $ret = [
            'error' => false,
            'messages' => [],
        ];

        $login = trim($this->request->post('login'));
        $password = trim($this->request->post('password'));

        if ($login == '') {
            $ret['error'] = true;
            $ret['messages'][] = [
                'type' => 'field_login',
                'message' => 'Campo "login" é obrigatório.',
            ];
        }

        if ($password == '') {
            $ret['error'] = true;
            $ret['messages'][] = [
                'type' => 'field_password',
                'message' => 'Campo "senha" é obrigatório.',
            ];
        }

        if (!$ret['error'] ) {
            $LoginHelper = new LoginHelper();
            $LoginHelper->login(true);

            $ret['messages'][] = [
                'type' => 'success',
                'message' => 'Login efetuado com sucesso.',
            ];
        }

        echo json_encode($ret);
	}

    public function logoutAction()
    {
        $LoginHelper = new LoginHelper();
        $LoginHelper->logout();
        $this->goToAction('');
    }
}
