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

    protected function view($path, $variables = false)
    {
        $extensions = ['html', 'php'];
        $file = null;

        foreach ($extensions as $ext) {
            $file_name = _DIR_VIEWS_ . $path . '.' . $ext;
            if (file_exists($file_name)) {
                $file = $file_name;
                break;
            }
        }

        if (!$file) {
            die('View nao encontrada');
        } else {
            $content = file_get_contents($file);

            if (is_array($variables)) {
                foreach ($variables as $k => $v) {
                    $content = str_replace('[[:' . $k . ']]', $v, $content);
                }
            }

            echo $content;
        }
    }
}
