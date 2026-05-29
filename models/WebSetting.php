<?php

require_once __DIR__ . '/BaseModel.php';

class WebSetting extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'web_settings';
    }

    public function getAllSettings()
    {
        $stmt = $this->db->query("SELECT * FROM web_settings ORDER BY id ASC");
        return $stmt->fetchAll();
    }

    public function getSimpleSettings()
    {
        $settings = $this->getAllSettings();

        $result = [];

        foreach ($settings as $setting) {
            $result[$setting['setting_key']] = $setting['setting_value'];
        }

        return $result;
    }

    public function getValue($key, $default = null)
    {
        $stmt = $this->db->prepare(
            "SELECT setting_value 
             FROM web_settings 
             WHERE setting_key = :key 
             LIMIT 1"
        );

        $stmt->execute([
            'key' => $key,
        ]);

        $row = $stmt->fetch();

        return $row ? $row['setting_value'] : $default;
    }

    public function getJsonValue($key)
    {
        $value = $this->getValue($key, '[]');

        $decoded = json_decode($value, true);

        return is_array($decoded) ? $decoded : [];
    }

    public function updateSetting($key, $value, $type = 'text')
    {
        $stmt = $this->db->prepare(
            "INSERT INTO web_settings (setting_key, setting_value, type, updated_at)
             VALUES (:setting_key, :setting_value, :type, NOW())
             ON DUPLICATE KEY UPDATE
                setting_value = VALUES(setting_value),
                type = VALUES(type),
                updated_at = NOW()"
        );

        return $stmt->execute([
            'setting_key' => $key,
            'setting_value' => $value,
            'type' => $type,
        ]);
    }

    public function updateMany($settings)
    {
        try {
            $this->db->beginTransaction();

            foreach ($settings as $key => $item) {
                $value = $item['value'] ?? '';
                $type = $item['type'] ?? 'text';

                $this->updateSetting($key, $value, $type);
            }

            $this->db->commit();

            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function appendImages($key, $images, $max = 8)
    {
        $current = $this->getJsonValue($key);

        foreach ($images as $image) {
            if (!empty($image)) {
                $current[] = $image;
            }
        }

        $current = array_values(array_unique($current));
        $current = array_slice($current, 0, $max);

        return $this->updateSetting($key, json_encode($current, JSON_UNESCAPED_UNICODE), 'json');
    }

    public function removeImageFromJson($key, $image)
    {
        $current = $this->getJsonValue($key);

        $current = array_values(array_filter($current, function ($item) use ($image) {
            return $item !== $image;
        }));

        return $this->updateSetting($key, json_encode($current, JSON_UNESCAPED_UNICODE), 'json');
    }
}
