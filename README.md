# Форма обратной связи

## Требования

- Docker
- Docker Compose

## Запуск

1. Для отправки почты используется PHPMailer с подключением к Mailtrap по SMTP.

   Переименуйте `config.example.php` в `config.php` и укажите в нём `mail_username` и `mail_password`.

   Можно использовать данные от моей тестовой песочницы:
   - `mail_username`: `ecdc11fbf78fa2`
   - `mail_password`: `6e6785a8332b21`

2. Выполните команду:

   ```bash
   docker compose up --build
   ```

3. Откройте приложение в браузере:

   ```text
   http://localhost:8080
   ```