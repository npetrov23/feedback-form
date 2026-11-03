# Запуск проекта

### Требования
- Docker
- Docker Compose

### Запуск

1. Для отправки почты используется PHPMailer с подключением к Mailtrap, поэтому нужно переименовать config.example.php в config.php и указать в нем mail_username и mail_password (можно использовать данные от моей тестовой песочницы: username ecdc11fbf78fa2, password 6e6785a8332b21)

2. Выполнить
```bash
docker compose up --build

3. Откройте приложение в браузере: http://localhost:8080