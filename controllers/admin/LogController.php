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

        $filters = [
            'action' => $_GET['action'] ?? '',
            'user_id' => $_GET['user_id'] ?? '',
            'date_from' => $_GET['date_from'] ?? '',
            'date_to' => $_GET['date_to'] ?? '',
        ];

        $logs = $logModel->getAllLogs($filters);

        $this->renderAdmin('logs/index', [
            'title' => 'Log hệ thống',
            'logs' => $logs,
            'filters' => $filters,
        ]);
    }

    public function clear()
    {
        requireAdmin();

        $logModel = new Log();
        $logModel->clearAll();

        createLog('clear_logs');

        header('Location: index.php?area=admin&controller=log&action=index');
        exit;
    }

    public function clearOld()
    {
        requireAdmin();

        $days = $_GET['days'] ?? 30;

        $logModel = new Log();
        $logModel->clearOld($days);

        createLog('clear_old_logs');

        header('Location: index.php?area=admin&controller=log&action=index');
        exit;
    }
}