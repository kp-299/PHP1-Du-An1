<?php

require_once __DIR__ . '/../BaseController.php';

require_once __DIR__ . '/../../models/Product.php';
require_once __DIR__ . '/../../models/Category.php';
require_once __DIR__ . '/../../models/Post.php';
require_once __DIR__ . '/../../models/Video.php';
require_once __DIR__ . '/../../models/WebSetting.php';
require_once __DIR__ . '/../../models/Cart.php';
require_once __DIR__ . '/../../models/ContactMessage.php';
require_once __DIR__ . '/../../helpers/mail.php';
require_once __DIR__ . '/../../helpers/log.php';

class ClientPagesController extends BaseController
{
    protected $folder = 'pages';

    public function home()
    {
        $productModel = new Product();
        $categoryModel = new Category();
        $postModel = new Post();
        $videoModel = new Video();
        $settingModel = new WebSetting();
        $cartModel = new Cart();

        $settings = $settingModel->getSimpleSettings();

        $categories = $categoryModel->getActive();

        $latestProducts = $productModel->getLatest(8);

        $activeProducts = $productModel->getActiveProducts();

        $posts = $postModel->getPublished(6);

        $videos = $videoModel->getPublished(6);

        $shortVideos = $videoModel->getAll([
            'video_type' => 'short',
            'status' => 'published',
            'limit' => 6,
            'offset' => 0,
        ]);

        $longVideos = $videoModel->getAll([
            'video_type' => 'long',
            'status' => 'published',
            'limit' => 6,
            'offset' => 0,
        ]);

        $cartItems = $cartModel->getItems();
        $cartTotalQuantity = $cartModel->getTotalQuantity();
        $cartTotalAmount = $cartModel->getTotalAmount();

        $this->render('home', [
            'title' => $settings['site_name'] ?? 'Trang chủ',
            'settings' => $settings,

            'categories' => $categories,

            'latestProducts' => $latestProducts,
            'activeProducts' => $activeProducts,

            'posts' => $posts,

            'videos' => $videos,
            'shortVideos' => $shortVideos,
            'longVideos' => $longVideos,

            'cartItems' => $cartItems,
            'cartTotalQuantity' => $cartTotalQuantity,
            'cartTotalAmount' => $cartTotalAmount,
        ]);
    }

    public function error()
    {
        $this->render('error', [
            'title' => '404 - Không tìm thấy trang',
        ]);
    }

    public function contact()
    {
        $settingModel = new WebSetting();
        $cartModel = new Cart();

        $settings = $settingModel->getSimpleSettings();

        $this->render('contact', [
            'title' => 'Liên hệ',
            'settings' => $settings,
            'errors' => [],
            'old' => [],
            'cartTotalQuantity' => $cartModel->getTotalQuantity(),
            'cartTotalAmount' => $cartModel->getTotalAmount(),
        ]);
    }

    public function handleContact()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?area=client&controller=pages&action=contact');
            exit;
        }

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $subject = trim($_POST['subject'] ?? '');
        $message = trim($_POST['message'] ?? '');

        $errors = [];

        if ($name === '') {
            $errors['name'] = 'Vui lòng nhập họ tên.';
        }

        if ($email === '') {
            $errors['email'] = 'Vui lòng nhập email.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email không hợp lệ.';
        }

        if ($phone !== '' && !preg_match('/^(0|\+84)[0-9]{9,10}$/', $phone)) {
            $errors['phone'] = 'Số điện thoại không hợp lệ.';
        }

        if ($subject === '') {
            $errors['subject'] = 'Vui lòng nhập chủ đề.';
        }

        if ($message === '') {
            $errors['message'] = 'Vui lòng nhập nội dung liên hệ.';
        } elseif (mb_strlen($message) < 10) {
            $errors['message'] = 'Nội dung liên hệ cần tối thiểu 10 ký tự.';
        }

        $settingModel = new WebSetting();
        $cartModel = new Cart();
        $settings = $settingModel->getSimpleSettings();

        if (!empty($errors)) {
            $this->render('contact', [
                'title' => 'Liên hệ',
                'settings' => $settings,
                'errors' => $errors,
                'old' => $_POST,
                'cartTotalQuantity' => $cartModel->getTotalQuantity(),
                'cartTotalAmount' => $cartModel->getTotalAmount(),
            ]);
            return;
        }

        $contactModel = new ContactMessage();

        $contactId = $contactModel->create([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'subject' => $subject,
            'message' => $message,
            'status' => 'new',
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '',
            'browser' => $_SERVER['HTTP_USER_AGENT'] ?? '',
        ]);

        if (!$contactId) {
            $this->render('contact', [
                'title' => 'Liên hệ',
                'settings' => $settings,
                'errors' => [
                    'general' => 'Gửi liên hệ thất bại, vui lòng thử lại.',
                ],
                'old' => $_POST,
                'cartTotalQuantity' => $cartModel->getTotalQuantity(),
                'cartTotalAmount' => $cartModel->getTotalAmount(),
            ]);
            return;
        }

        $adminEmail = $settings['contact_email'] ?? '';

        sendContactMail($adminEmail, [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'subject' => $subject,
            'message' => $message,
        ]);

        createLog('send_contact_message_' . $contactId);

        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Gửi liên hệ thành công. Chúng tôi sẽ phản hồi sớm nhất có thể.',
        ];

        header('Location: index.php?area=client&controller=pages&action=contact');
        exit;
    }
}
