<?php

require_once __DIR__ . '/../BaseController.php';

require_once __DIR__ . '/../../models/Video.php';
require_once __DIR__ . '/../../models/WebSetting.php';
require_once __DIR__ . '/../../models/Cart.php';

class ClientVideoController extends BaseController
{
    protected $folder = 'pages';

    public function index()
    {
        $videoModel = new Video();
        $settingModel = new WebSetting();
        $cartModel = new Cart();

        $settings = $settingModel->getSimpleSettings();

        $keyword = trim($_GET['keyword'] ?? '');
        $sort = trim($_GET['sort'] ?? 'newest');

        $page = max(1, (int)($_GET['page'] ?? 1));
        $limit = 18;
        $offset = ($page - 1) * $limit;

        $baseFilters = [
            'keyword' => $keyword,
            'status' => 'published',
            'sort' => $sort,
            'limit' => $limit,
            'offset' => $offset,
        ];

        $shortVideos = $videoModel->getAll(array_merge($baseFilters, [
            'video_type' => 'short',
            'limit' => 12,
            'offset' => 0,
        ]));

        $longVideos = $videoModel->getAll(array_merge($baseFilters, [
            'video_type' => 'long',
            'limit' => 8,
            'offset' => 0,
        ]));

        $totalVideos = $videoModel->countFiltered($baseFilters);
        $totalPages = max(1, (int)ceil($totalVideos / $limit));

        $this->render('videos', [
            'title' => 'Video',
            'settings' => $settings,

            'shortVideos' => $shortVideos,
            'longVideos' => $longVideos,

            'filters' => [
                'keyword' => $keyword,
                'sort' => $sort,
            ],

            'page' => $page,
            'totalPages' => $totalPages,
            'totalVideos' => $totalVideos,

            'cartTotalQuantity' => $cartModel->getTotalQuantity(),
            'cartTotalAmount' => $cartModel->getTotalAmount(),
        ]);
    }
}
