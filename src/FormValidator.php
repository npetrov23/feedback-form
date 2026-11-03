<?php

namespace App;

class FormValidator
{
    private const MAX_LENGTH_INPUT = 255;
    private const MAX_LENGTH_TEXTAREA = 4096;

    private array $errors = [];

    public function validate(array $data): array
    {
        $this->errors = [];

        $this->validateRequired($data);
        $this->validateLengths($data);
        $this->validatePhone($data);
        $this->validateEmail($data);
        $this->validateCaptcha($data);

        return $this->errors;
    }

    private function validateRequired(array $data): void
    {
        $fields = [
            'subject',
            'fio',
            'email',
            'message',
            'agree',
            'captcha'
        ];

        foreach ($fields as $field) {
            
            $value = (string) ($data[$field] ?? '');
            $value = trim($value);

            if ($value === '') {
                $this->addError($field, 'Поле обязательно для заполнения');
            }
        }
    }

    private function validateLengths(array $data): void
    {
        $limits = [
            'subject' => self::MAX_LENGTH_INPUT,
            'fio' => self::MAX_LENGTH_INPUT,
            'phone' => self::MAX_LENGTH_INPUT,
            'email' => self::MAX_LENGTH_INPUT,
            'message' => self::MAX_LENGTH_TEXTAREA
        ];

        foreach ($limits as $field => $maxLength) {
            $value = (string) ($data[$field] ?? '');

            if (mb_strlen($value) > $maxLength) {
                $this->addError(
                    $field,
                    "Максимальное количество символов: {$maxLength}"
                );
            }
        }
    }

    private function validatePhone(array $data): void
    {
        $phone = (string) ($data['phone'] ?? '');
        $phone = trim($phone);

        if ($phone === '') {
            return;
        }

        $phone = preg_replace('/[\s()-]/u', '', $phone);

        if (!preg_match('/^(?:\+7|7|8)\d{10}$/', $phone)) {
            $this->addError('phone', 'Некорректный формат номера телефона');
        }
    }

    private function validateEmail(array $data): void
    {
        $email = (string) ($data['email'] ?? '');
        $email = trim($email);

        if ($email === '') {
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->addError('email', 'Некорректный формат электронной почты');
        }
    }

    private function validateCaptcha(array $data): void
    {
        $captcha = new Captcha();
        $answer = (string) ($data['captcha'] ?? '');

        if (!$captcha->validate($answer)) {
            $this->addError('captcha', 'Неверный код с картинки');
        }
    }

    private function addError(string $field, string $message): void
    {
        $this->errors[$field][] = $message;
    }
}