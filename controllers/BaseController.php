<?php

class BaseController
{
    protected $folder;

    public function render($viewName, $data = [])
    {
        $viewPath = __DIR__ . '/../views/' . $this->folder . '/' . $viewName . '.php';

        if (!file_exists($viewPath)) {
            header('Location: index.php?area=client&controller=pages&action=error');
            exit;
        }

        extract($data);

        ob_start();
        require $viewPath;
        $content = ob_get_clean();

        // Layout client của bạn đang nằm ở views/app.php
        require __DIR__ . '/../views/app.php';
    }

    public function renderAdmin($viewName, $data = [])
    {
        $viewPath = __DIR__ . '/../views/admin/' . $viewName . '.php';

        if (!file_exists($viewPath)) {
            die('Admin view not found: ' . $viewPath);
        }

        extract($data);

        ob_start();
        require $viewPath;
        $content = ob_get_clean();

        // Layout admin nằm ở views/layouts/admin.php
        require __DIR__ . '/../views/layouts/admin.php';
    }
}
