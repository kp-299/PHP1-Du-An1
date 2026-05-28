<?php

/**
 * FILE: models/WebSetting.php
 * CHỨC NĂNG: Model xử lý bảng web_settings
 */

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
        $sql = "
            SELECT *
            FROM web_settings
            ORDER BY id ASC
        ";

        $stmt = $this->db->query($sql);

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

    public function getValue($key)
    {
        $sql = "
            SELECT setting_value
            FROM web_settings
            WHERE setting_key = :setting_key
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'setting_key' => $key
        ]);

        $result = $stmt->fetch();

        if (!$result) {
            return null;
        }

        return $result['setting_value'];
    }

    public function updateSetting($key, $value)
    {
        $sql = "
            UPDATE web_settings
            SET 
                setting_value = :setting_value,
                updated_at = NOW()
            WHERE setting_key = :setting_key
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'setting_key' => $key,
            'setting_value' => $value
        ]);
    }

    public function createOrUpdate($key, $value, $type = 'text')
    {
        $currentValue = $this->getValue($key);

        if ($currentValue !== null) {
            return $this->updateSetting($key, $value);
        }

        $sql = "
            INSERT INTO web_settings (
                setting_key,
                setting_value,
                type
            )
            VALUES (
                :setting_key,
                :setting_value,
                :type
            )
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'setting_key' => $key,
            'setting_value' => $value,
            'type' => $type
        ]);
    }

    public function updateMany($settings)
    {
        try {
            $this->beginTransaction();

            foreach ($settings as $key => $value) {
                $this->createOrUpdate($key, $value);
            }

            $this->commit();

            return true;
        } catch (Exception $e) {
            $this->rollback();

            return false;
        }
    }
}