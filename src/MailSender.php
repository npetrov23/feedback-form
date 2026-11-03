<?php

namespace App;

use PHPMailer\PHPMailer\PHPMailer;

class MailSender
{
    public function __construct(
        private string $subject = 'Тема письма'
    ) {}

    public function send(array $data): bool
    {
        $mail = new PHPMailer(true);

        try {
            $config = $this->getConfig();

            $mail->isSMTP();
            $mail->Host = $config['mail_host'];
            $mail->SMTPAuth = true;
            $mail->Username = $config['mail_username'];
            $mail->Password = $config['mail_password'];
            $mail->Port = $config['mail_port'];

            $mail->CharSet = 'UTF-8';
            $mail->setFrom('no-reply@example.com');
            $mail->addAddress($data['email']);

            $mail->Subject = $this->subject;
            $mail->Body = $this->getMessage($data);

            return $mail->send();
        } catch (\Exception $e) {
            return false;
        }
    }

    private function getMessage(array $data): string
    {
        $phone = (string) ($data['phone'] ?? '');

        return "
            Имя: {$data['fio']}
            Телефон: {$phone}
            Email: {$data['email']}
            Тема: {$data['subject']}

            Сообщение:
            {$data['message']}
        ";
    }

    private function getConfig(): array
    {
        return require __DIR__ . '/../config.php';
    }
}