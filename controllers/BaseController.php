<?php

class BaseController
{
    protected $folder;

    public function render($viewName, $data = [])
    {
        $viewPath = __DIR__ . '/../views/' . $this->folder . '/' . $viewName . '.php';

        if (!file_exists($viewPath)) {
            die('Client view not found: ' . $viewPath);
        }

        extract($data);

        ob_start();
        require $viewPath;
        $content = ob_get_clean();

        require __DIR__ . '/../views/app.php';
    }
}

