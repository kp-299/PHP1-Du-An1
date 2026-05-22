<?php

class BaseController
{
    protected $folder;

    public function render($viewName, $data = [])
    {
        // Tạo đường dẫn tới file view
        $viewPath = __DIR__ . '/../views/' . $this->folder . '/' . $viewName . '.php';

        // Nếu file view không tồn tại thì chuyển sang trang lỗi
        if (!file_exists($viewPath)) {
            header('Location: index.php?controller=pages&action=error');
            exit;
        }

        // Chuyển array data thành biến để dùng trong view
        // Ví dụ: ['title' => 'Home'] thành biến $title
        extract($data);

        // Lưu nội dung view vào biến $content
        ob_start();
        require $viewPath;
        $content = ob_get_clean();

        // Gọi layout chính
        require __DIR__ . '/../views/layouts/app.php';
    }
}
}
