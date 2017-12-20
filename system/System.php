<?php

class System
{
	private $url;
	private $explode;
	private $controller;
	private $action;
	private $params;
	private $final_controller;
	private $final_action;

	public function __construct()
	{
		$this->setUrl();
		$this->setExplode();
		$this->setController();
		$this->setAction();
		$this->setParams();
		$this->arrangeControllerAction();
	}

	private function setUrl()
	{
		global $config;

		if ($config['user_server_path']) {
			$this->url = isset($_SERVER['REQUEST_URI']) ? trim($_SERVER['REQUEST_URI']) : '';
		} else {
			$this->url = isset($_GET['url']) ? trim($_GET['url']) : '';
		}
	}

	private function setExplode($list = false)
	{
		$explode = is_array($list) ? $list : explode('/', $this->url);

		$this->explode = array_reduce($explode, function ($a, $c) {
			$c = trim($c);
			if ($c != '') $a[] = $c;
			return $a;
		}, []);
	}

	private function setController()
	{
		if (isset($this->explode[0])) {
			$this->controller = $this->explode[0];
			unset($this->explode[0]);
			$this->setExplode($this->explode);
		} else {
			$this->controller = _CONTROLLER_DEFAULT_;
		}
	}

	public function getController()
	{
		return $this->controller;
	}

	private function setAction()
	{
		if (isset($this->explode[0])) {
			$this->action = $this->explode[0];
			unset($this->explode[0]);
			$this->setExplode($this->explode, 1);
		} else {
			$this->action = _ACTION_DEFAULT_;
		}
	}

	public function getAction()
	{
		return $this->action;
	}

	private function setParams()
	{
		$params = array_reduce($this->explode, function ($a, $c) {
			if (is_null($a[1])) {
				$a[1] = $c;
			} else {
				$a[0][$a[1]] = $c;
				$a[1] = null;
			}
			return $a;
		}, [[], null]);
		$this->params = $params[0];
	}

	public function getParams()
	{
		return $this->params;
	}

	private function arrangeControllerAction()
	{
		$this->final_controller = implode('', array_map(function ($a) {
			return ucwords($a);
		}, explode('-', $this->controller . '-controller')));

		$this->final_action = lcfirst(implode('', array_map(function ($a) {
			return ucwords($a);
		}, explode('-', $this->action . '-action'))));
	}

	public function run()
	{
		$controller_directory = _DIR_CONTROLLERS_;
		$controller_file = $controller_directory . $this->final_controller . '.php';

		if (!file_exists($controller_file)) {
			die('Erro 404 : Controller nao encontrada');
		} else {
			$c = new $this->final_controller();
			if (!method_exists($c, $this->final_action)) {
				die('Erro 404 : Action nao encontrada');
			} else {
				$a = $this->final_action;
				$c->$a();
			}
		}
	}
}
