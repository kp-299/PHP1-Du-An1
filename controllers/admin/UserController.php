<?php

require_once __DIR__ . '/../BaseController.php';

require_once __DIR__ . '/../../helpers/auth.php';
require_once __DIR__ . '/../../helpers/log.php';

require_once __DIR__ . '/../../models/User.php';

class AdminUserController extends BaseController
{
    public function index()
    {
        requireAdmin();

        $userModel = new User();

        $filters = [
            'keyword' => trim($_GET['keyword'] ?? ''),
            'role' => $_GET['role'] ?? '',
            'status' => $_GET['status'] ?? '',
        ];

        $users = $userModel->getAllUsers($filters);

        $this->renderAdmin('users/index', [
            'title' => 'Quản lý người dùng',
            'users' => $users,
            'filters' => $filters,
        ]);
    }

    public function detail()
    {
        requireAdmin();

        $id = $_GET['id'] ?? null;

        $userModel = new User();
        $user = $userModel->find($id);

        if (!$user) {
            header('Location: index.php?area=admin&controller=user&action=index');
            exit;
        }

        $this->renderAdmin('users/detail', [
            'title' => 'Chi tiết người dùng',
            'user' => $user,
        ]);
    }

    public function updateStatus()
    {
        requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?area=admin&controller=user&action=index');
            exit;
        }

        $id = $_POST['id'] ?? null;
        $status = $_POST['status'] ?? 'active';

        if ((int) $id === (int) currentUserId()) {
            header('Location: index.php?area=admin&controller=user&action=index');
            exit;
        }

        $userModel = new User();
        $userModel->updateStatus($id, $status);

        createLog('update_user_status');

        header('Location: index.php?area=admin&controller=user&action=index');
        exit;
    }

    public function updateRole()
    {
        requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?area=admin&controller=user&action=index');
            exit;
        }

        $id = $_POST['id'] ?? null;
        $role = $_POST['role'] ?? 'user';

        if ((int) $id === (int) currentUserId()) {
            header('Location: index.php?area=admin&controller=user&action=index');
            exit;
        }

        $userModel = new User();
        $userModel->updateRole($id, $role);

        createLog('update_user_role');

        header('Location: index.php?area=admin&controller=user&action=index');
        exit;
    }

    public function lock()
    {
        requireAdmin();

        $id = $_GET['id'] ?? null;

        if ((int) $id === (int) currentUserId()) {
            header('Location: index.php?area=admin&controller=user&action=index');
            exit;
        }

        $userModel = new User();
        $userModel->updateStatus($id, 'blocked');

        createLog('lock_user');

        header('Location: index.php?area=admin&controller=user&action=index');
        exit;
    }

    public function unlock()
    {
        requireAdmin();

        $id = $_GET['id'] ?? null;

        $userModel = new User();
        $userModel->updateStatus($id, 'active');

        createLog('unlock_user');

        header('Location: index.php?area=admin&controller=user&action=index');
        exit;
    }
}