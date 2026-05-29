<?php

require_once __DIR__ . '/../BaseController.php';

require_once __DIR__ . '/../../helpers/auth.php';
require_once __DIR__ . '/../../helpers/log.php';

require_once __DIR__ . '/../../models/Log.php';

class AdminLogController extends BaseController
{
    public function index()
    {
        requireAdmin();

        $logModel = new Log();

        $page = max(1, (int)($_GET['page'] ?? 1));
        $limit = 15;
        $offset = ($page - 1) * $limit;

        $filters = [
            'log_action' => trim($_GET['log_action'] ?? ''),
            'user_id' => trim($_GET['user_id'] ?? ''),
            'method' => trim($_GET['method'] ?? ''),
            'date_from' => trim($_GET['date_from'] ?? ''),
            'date_to' => trim($_GET['date_to'] ?? ''),
            'limit' => $limit,
            'offset' => $offset,
        ];

        $logs = $logModel->getAllLogs($filters);
        $totalLogs = $logModel->countFiltered($filters);
        $totalPages = max(1, (int)ceil($totalLogs / $limit));

        $this->renderAdmin('logs/index', [
            'title' => 'Log hệ thống',
            'logs' => $logs,
            'filters' => $filters,
            'page' => $page,
            'totalPages' => $totalPages,
            'totalLogs' => $totalLogs,
        ]);
    }

    public function clear()
    {
        requireAdmin();

        $logModel = new Log();
        $logModel->clearAll();

        createLog('clear_logs');

        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Đã xóa toàn bộ logs.',
        ];

        header('Location: index.php?area=admin&controller=log&action=index');
        exit;
    }

    public function clearOld()
    {
        requireAdmin();

        $days = max(1, (int)($_GET['days'] ?? 30));

        $logModel = new Log();
        $logModel->clearOld($days);

        createLog('clear_old_logs_' . $days . '_days');

        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Đã xóa logs cũ hơn ' . $days . ' ngày.',
        ];

        header('Location: index.php?area=admin&controller=log&action=index');
        exit;
    }
}
