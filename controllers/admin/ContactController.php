<?php

require_once __DIR__ . '/../BaseController.php';

require_once __DIR__ . '/../../helpers/auth.php';
require_once __DIR__ . '/../../helpers/log.php';

require_once __DIR__ . '/../../models/ContactMessage.php';

class AdminContactController extends BaseController
{
    public function index()
    {
        requireAdmin();

        $contactModel = new ContactMessage();

        $page = max(1, (int)($_GET['page'] ?? 1));
        $limit = 15;
        $offset = ($page - 1) * $limit;

        $filters = [
            'keyword' => trim($_GET['keyword'] ?? ''),
            'status' => trim($_GET['status'] ?? ''),
            'date_from' => trim($_GET['date_from'] ?? ''),
            'date_to' => trim($_GET['date_to'] ?? ''),
            'limit' => $limit,
            'offset' => $offset,
        ];

        $messages = $contactModel->getAll($filters);
        $totalMessages = $contactModel->countFiltered($filters);
        $totalPages = max(1, (int)ceil($totalMessages / $limit));

        $this->renderAdmin('contacts/index', [
            'title' => 'Liên hệ',
            'messages' => $messages,
            'filters' => $filters,
            'page' => $page,
            'totalPages' => $totalPages,
            'totalMessages' => $totalMessages,
        ]);
    }

    public function detail()
    {
        requireAdmin();

        $id = $_GET['id'] ?? null;

        $contactModel = new ContactMessage();
        $message = $contactModel->findById($id);

        if (!$message) {
            header('Location: index.php?area=admin&controller=contact&action=index');
            exit;
        }

        if (($message['status'] ?? '') === 'new') {
            $contactModel->updateStatus($id, 'read');
            $message['status'] = 'read';
        }

        $this->renderAdmin('contacts/detail', [
            'title' => 'Chi tiết liên hệ',
            'message' => $message,
        ]);
    }

    public function updateStatus()
    {
        requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?area=admin&controller=contact&action=index');
            exit;
        }

        $id = $_POST['id'] ?? null;
        $status = $_POST['status'] ?? 'read';

        if (!in_array($status, ['new', 'read', 'replied', 'archived'], true)) {
            $status = 'read';
        }

        $contactModel = new ContactMessage();
        $contactModel->updateStatus($id, $status);

        createLog('update_contact_status_' . $id);

        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Đã cập nhật trạng thái liên hệ.',
        ];

        header('Location: index.php?area=admin&controller=contact&action=detail&id=' . $id);
        exit;
    }

    public function updateNote()
    {
        requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?area=admin&controller=contact&action=index');
            exit;
        }

        $id = $_POST['id'] ?? null;
        $adminNote = trim($_POST['admin_note'] ?? '');

        $contactModel = new ContactMessage();
        $contactModel->updateNote($id, $adminNote);

        createLog('update_contact_note_' . $id);

        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Đã lưu ghi chú liên hệ.',
        ];

        header('Location: index.php?area=admin&controller=contact&action=detail&id=' . $id);
        exit;
    }

    public function delete()
    {
        requireAdmin();

        $id = $_GET['id'] ?? null;

        $contactModel = new ContactMessage();
        $contactModel->delete($id);

        createLog('delete_contact_message_' . $id);

        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Đã xóa liên hệ.',
        ];

        header('Location: index.php?area=admin&controller=contact&action=index');
        exit;
    }
}
