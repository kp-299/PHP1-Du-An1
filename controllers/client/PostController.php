<?php

require_once __DIR__ . '/../BaseController.php';

require_once __DIR__ . '/../../helpers/log.php';

require_once __DIR__ . '/../../models/Post.php';
require_once __DIR__ . '/../../models/Video.php';
require_once __DIR__ . '/../../models/WebSetting.php';
require_once __DIR__ . '/../../models/Cart.php';

class ClientPostController extends BaseController
{
    protected $folder = 'pages';

    public function index()
    {
        createLog('view_posts_page');

        $postModel = new Post();
        $settingModel = new WebSetting();
        $cartModel = new Cart();

        $settings = $settingModel->getSimpleSettings();

        $keyword = trim($_GET['keyword'] ?? '');
        $sort = trim($_GET['sort'] ?? 'newest');

        $page = max(1, (int)($_GET['page'] ?? 1));
        $limit = 9;
        $offset = ($page - 1) * $limit;

        $filters = [
            'keyword' => $keyword,
            'status' => 'published',
            'sort' => $sort,
            'limit' => $limit,
            'offset' => $offset,
        ];

        $posts = $postModel->getAll($filters);
        $totalPosts = $postModel->countFiltered($filters);
        $totalPages = max(1, (int)ceil($totalPosts / $limit));

        $randomPosts = $postModel->getRandom(5);

        $this->render('posts', [
            'title' => 'Bài viết',
            'settings' => $settings,

            'posts' => $posts,
            'randomPosts' => $randomPosts,

            'filters' => [
                'keyword' => $keyword,
                'sort' => $sort,
            ],

            'page' => $page,
            'totalPages' => $totalPages,
            'totalPosts' => $totalPosts,

            'cartTotalQuantity' => $cartModel->getTotalQuantity(),
            'cartTotalAmount' => $cartModel->getTotalAmount(),
        ]);
    }

    public function detail()
    {
        $slug = trim($_GET['slug'] ?? '');

        if ($slug === '') {
            createLog('view_post_detail_missing_slug');

            header('Location: index.php?area=client&controller=post&action=index');
            exit;
        }

        $postModel = new Post();
        $videoModel = new Video();
        $settingModel = new WebSetting();
        $cartModel = new Cart();

        $settings = $settingModel->getSimpleSettings();

        $post = $postModel->findBySlug($slug);

        if (!$post || ($post['status'] ?? '') !== 'published') {
            createLog('view_post_detail_not_found');

            header('Location: index.php?area=client&controller=pages&action=error');
            exit;
        }

        $postModel->increaseView($post['id']);

        createLog('view_post_detail_' . $post['id']);

        $relatedPosts = $postModel->getRelated($post['id'], 6);
        $latestVideos = $videoModel->getPublished(8);

        $this->render('postDetail', [
            'title' => $post['title'],
            'settings' => $settings,

            'post' => $post,
            'relatedPosts' => $relatedPosts,
            'latestVideos' => $latestVideos,

            'cartTotalQuantity' => $cartModel->getTotalQuantity(),
            'cartTotalAmount' => $cartModel->getTotalAmount(),
        ]);
    }
}
