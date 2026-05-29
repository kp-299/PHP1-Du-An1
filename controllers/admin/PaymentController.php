<?php

require_once __DIR__ . '/../BaseController.php';

require_once __DIR__ . '/../../helpers/auth.php';
require_once __DIR__ . '/../../helpers/log.php';
require_once __DIR__ . '/../../helpers/upload.php';

require_once __DIR__ . '/../../models/PaymentSetting.php';

class AdminPaymentController extends BaseController
{
    public function index()
    {
        requireAdmin();

        $paymentSettingModel = new PaymentSetting();
        $paymentSettings = $paymentSettingModel->getSimpleSettings();

        $this->renderAdmin('payments/index', [
            'title' => 'Cài đặt thanh toán',
            'paymentSettings' => $paymentSettings,
        ]);
    }

    public function update()
    {
        requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?area=admin&controller=payment&action=index');
            exit;
        }

        $paymentSettingModel = new PaymentSetting();

        $paymentSettingModel->updateMany([
            'qr_enabled' => [
                'value' => ($_POST['qr_enabled'] ?? '0') === '1' ? '1' : '0',
                'type' => 'text',
            ],
            'cod_enabled' => [
                'value' => ($_POST['cod_enabled'] ?? '0') === '1' ? '1' : '0',
                'type' => 'text',
            ],
            'bank_name' => [
                'value' => trim($_POST['bank_name'] ?? ''),
                'type' => 'text',
            ],
            'bank_account_name' => [
                'value' => trim($_POST['bank_account_name'] ?? ''),
                'type' => 'text',
            ],
            'bank_account_number' => [
                'value' => trim($_POST['bank_account_number'] ?? ''),
                'type' => 'text',
            ],
            'bank_transfer_content' => [
                'value' => trim($_POST['bank_transfer_content'] ?? 'THANHTOAN DONHANG {order_id}'),
                'type' => 'text',
            ],
        ]);

        if (!empty($_FILES['bank_qr_image']['name'])) {
            $qrImage = uploadImage($_FILES['bank_qr_image'], 'uploads/payments');

            if ($qrImage) {
                $paymentSettingModel->updateSetting('bank_qr_image', $qrImage, 'image');
            }
        }

        createLog('update_payment_settings');

        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Đã lưu cài đặt thanh toán.',
        ];

        header('Location: index.php?area=admin&controller=payment&action=index');
        exit;
    }
}
