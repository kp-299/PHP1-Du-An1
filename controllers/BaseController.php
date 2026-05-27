<?php

class BaseController
{
    protected $folder;

    /**
     * Render view client
     *
     * Ví dụ:
     * $this->folder = 'pages';
     * $this->render('home', [...]);
     *
     * Sẽ gọi:
     * views/pages/home.php
     * views/layouts/app.php
     */
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

        require __DIR__ . '/../views/layouts/app.php';
    }

    /**
     * Render view admin
     *
     * Ví dụ:
     * $this->renderAdmin('products/index', [...]);
     *
     * Sẽ gọi:
     * views/admin/products/index.php
     * views/layouts/admin.php
     */
    public function renderAdmin($viewName, $data = [])
    {
        $viewPath = __DIR__ . '/../views/admin/' . $viewName . '.php';

        if (!file_exists($viewPath)) {
            header('Location: index.php?area=client&controller=pages&action=error');
            exit;
        }

        extract($data);

        ob_start();
        require $viewPath;
        $content = ob_get_clean();

        require __DIR__ . '/../views/layouts/admin.php';
    }
}