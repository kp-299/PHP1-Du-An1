<?php

require_once __DIR__ . '/BaseController.php';

class PagesController extends BaseController
{
    protected $folder = 'pages';

    public function home()
    {
        $this->render('home', [
            'title' => 'Trang chủ',
            'message' => 'Hello PHP MVC',
        ]);
    }

    public function error()
    {
        $this->render('error');
    }
}