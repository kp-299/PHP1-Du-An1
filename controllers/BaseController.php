<?php

class BaseController
{
  protected $folder;

  public function render($file, $data = [])
  {
    $viewFile = __DIR__ . '/../views/' . $this->folder . '/' . $file . '.php';

    if (is_file($viewFile)) {
      extract($data);

      ob_start();
      require_once $viewFile;
      $content = ob_get_clean();

      require_once __DIR__ . '/../views/app.php';
    } else {
      header('Location: index.php?controller=pages&action=error');
      exit;
    }
  }
}