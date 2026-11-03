
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Обратная связь</title>
    <link rel="stylesheet" href="static/css/style.css">
</head>
<body>
    <main class="wrapper">
        <div class="feedback">
            <div class="feedback__error-container" hidden>
                <div class="response-container">
                    <div class="response-message">
                        <strong>Некоторые поля заполнены некорректно.</strong>

                        <ul>

                        </ul>
                    </div>
                </div>
            </div>
            <div class="feedback__success-container" hidden>
                <div class="response-container">
                    <div class="response-message">
                        <strong>Сообщение успешно отправлено!</strong>
                    </div>
                </div>
            </div>
            <div class="feedback__form-container">
                <form class="feedback__form" action="send.php" method="post" novalidate>
                    <input type="hidden" name="action" value="message">

                    <div class="field">
                        <label for="subject">Тема</label>
                        <select id="subject" class="field__select" name="subject" required>
                            <option value="" selected disabled>Выберите тему</option>
                            <option value="question">Тема 1</option>
                            <option value="support">Тема 2</option>
                            <option value="cooperation">Тема 3</option>
                        </select>
                    </div>

                    <div class="field">
                        <label for="fio">ФИО</label>
                        <input id="fio" class="field__input" name="fio" type="text" autocomplete="name" required>
                    </div>

                    <div class="field">
                        <label for="phone">Телефон</label>
                        <input id="phone" class="field__input" name="phone" type="text" placeholder="+7 (___) ___-__-__" autocomplete="tel">
                    </div>

                    <div class="field">
                        <label for="email">E-mail</label>
                        <input id="email" class="field__input" name="email" type="text" autocomplete="email" required>
                    </div>

                    <div class="field">
                        <label for="message">Сообщение</label>
                        <textarea id="message" class="field__textarea" name="message" rows="6" required></textarea>
                    </div>

                    <div class="field field--checkbox">
                        <label for="agree" class="checkbox">
                            <input type="checkbox" id="agree" name="agree" value="1" required>
                            <span>Согласие на обработку персональных данных</span>
                        </label>
                    </div>

            <div class="field captcha">
                <label class="captcha__title" for="captcha">
                    Капча <span>*</span>
                </label>

                <p class="captcha__hint">Введите код с картинки</p>

                <div class="captcha__input-row">
                    <input
                        class="captcha__input"
                        type="text"
                        name="captcha"
                        id="captcha"
                        autocomplete="off"
                        required
                    >

                    <button class="captcha__refresh" type="button" aria-label="Обновить капчу">
                        &#10227;
                    </button>
                </div>

                <div class="captcha__image-wrapper">
                    <img class="captcha__image" src="captcha.php" alt="CAPTCHA">
                </div>

                <div class="captcha__error"></div>
            </div>

                    <button class="btn" type="submit" class="btn" id="submit-btn">Отправить</button>
                </form>
            </div>
        </div>


    </main>
    <script type="module" src="static/js/main.js"></script>
</body>
</html>