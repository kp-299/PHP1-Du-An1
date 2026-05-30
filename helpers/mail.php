<?php

function sendContactMail($to, $data)
{
    if (empty($to)) {
        return false;
    }

    $subject = '[Contact Website] ' . ($data['subject'] ?? 'Liên hệ mới');

    $name = $data['name'] ?? '';
    $email = $data['email'] ?? '';
    $phone = $data['phone'] ?? '';
    $message = $data['message'] ?? '';

    $body = "
Bạn có một liên hệ mới từ website:

Họ tên: {$name}
Email: {$email}
Số điện thoại: {$phone}
Chủ đề: {$subject}

Nội dung:
{$message}
";

    $headers = [];
    $headers[] = 'From: Website Contact <no-reply@localhost>';
    $headers[] = 'Reply-To: ' . $email;
    $headers[] = 'Content-Type: text/plain; charset=UTF-8';

    return mail($to, $subject, $body, implode("\r\n", $headers));
}
