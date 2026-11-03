<?php

namespace App;

class FormService
{
    public function __construct(
        private FormValidator $validator,
        private MailSender $mailSender
    ) {}

    public function handle(array $data): array
    {
        $errors = $this->validator->validate($data);

        if (!empty($errors)) {
            return [
                'success' => false,
                'errors' => $errors
            ];
        }

        if (!$this->mailSender->send($data)) {
            return [
                'success' => false,
                'message' => 'Не удалось отправить сообщение'
            ];
        }

        return [
            'success' => true,
            'message' => 'Сообщение успешно отправлено'
        ];
    }
}