<?php

require_once __DIR__ . '/BaseModel.php';

class PaymentSetting extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'payment_settings';
    }

    public function getAllSettings()
    {
        $sql = "SELECT * FROM payment_settings";
        $stmt = $this->db->query($sql);

        return $stmt->fetchAll();
    }

    public function getSimpleSettings()
    {
        $settings = [];

        foreach ($this->getAllSettings() as $row) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }

        return $settings;
    }

    public function getValue($key, $default = '')
    {
        $sql = "
            SELECT setting_value
            FROM payment_settings
            WHERE setting_key = :setting_key
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'setting_key' => $key,
        ]);

        $row = $stmt->fetch();

        return $row ? $row['setting_value'] : $default;
    }

    public function updateSetting($key, $value, $type = 'text')
    {
        $sql = "
            INSERT INTO payment_settings (
                setting_key,
                setting_value,
                type,
                created_at,
                updated_at
            )
            VALUES (
                :setting_key,
                :setting_value,
                :type,
                NOW(),
                NOW()
            )
            ON DUPLICATE KEY UPDATE
                setting_value = VALUES(setting_value),
                type = VALUES(type),
                updated_at = NOW()
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'setting_key' => $key,
            'setting_value' => $value,
            'type' => $type,
        ]);
    }

    public function updateMany($items)
    {
        foreach ($items as $key => $item) {
            $value = $item['value'] ?? '';
            $type = $item['type'] ?? 'text';

            $this->updateSetting($key, $value, $type);
        }

        return true;
    }
}
