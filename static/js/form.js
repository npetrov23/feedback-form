import { validate, ERROR_CLASSES } from './validate.js';

const ERROR_MSG_CLASS = 'field__error-msg';
const CAPTCHA_ENDPOINT = 'captcha.php';

const fieldNames = {
    subject: 'Тема',
    fio: 'ФИО',
    phone: 'Телефон',
    email: 'E-mail',
    message: 'Сообщение',
    agree: 'Согласие на обработку персональных данных',
    captcha: 'Капча'
};

export function initForm() {
    const form = document.querySelector('.feedback__form');
    const captchaImage = form.querySelector('.captcha__image');
    const captchaRefresh = form.querySelector('.captcha__refresh');

    form.addEventListener('submit', (event) => {
        event.preventDefault();    

        const errors = validate(collectData(form));

        clearErrors();

        if(Object.keys(errors).length === 0) {
            send();
        } else {
            showFieldError(errors);
        }
        
    });

    captchaRefresh.addEventListener('click', () => {
        captchaImage.src = CAPTCHA_ENDPOINT + '?t=' + Date.now();
    });
}

function collectData(form) {
    const formData = new FormData(form);
    
    if(!formData.has('agree')) {
        formData.append('agree', '0');
    }

    return {
        ...Object.fromEntries(formData.entries()),
        raw_data: form
    };
}

function showFieldError(validate) {
    for (const [fieldName, messages] of Object.entries(validate)) {
        const label = document.querySelector(`label[for="${fieldName}"]`);
        const field = document.querySelector(`[name=${fieldName}]`);

        if(label) {
            label.classList.add(ERROR_CLASSES.label);
        }

        if(field) {
            field.classList.add(ERROR_CLASSES.border);
        }

        for (const message of messages) {
            const error = document.createElement('span');

            error.classList.add(ERROR_MSG_CLASS);
            error.dataset.errorFor = fieldName;
            error.textContent = message;

            if (fieldName === 'captcha') {
                document.querySelector('.captcha__error').append(error);
            } else if (field.type === 'checkbox') {
                field.closest('.field').append(error);
            } else {
                field.parentElement.append(error);
            }
        }
    }
}

function send() {
    const form = document.querySelector('.feedback__form');
    const errorContainer = document.querySelector('.feedback__error-container');
    const successContainer = document.querySelector('.feedback__success-container');
    const errorList = errorContainer.querySelector('ul');
    const submitButton = form.querySelector('[type="submit"]');
    const captchaImage = form.querySelector('.captcha__image');

    submitButton.disabled = true;
    submitButton.textContent = 'Отправка...';

    fetch('send.php', {
        method: 'POST',
        body: new FormData(form)
    })
        .then(response => {
            return response.json();
        })
        .then(result => {
            errorList.innerHTML = '';

            if (result.success) {
                errorContainer.hidden = true;
                successContainer.hidden = false;
                form.reset();
                return;
            }

            Object.entries(result.errors).forEach(([field, errors]) => {
                errors.forEach(error => {
                    const li = document.createElement('li');
                    li.textContent = `${fieldNames[field] ?? field}: ${error}`;
                    errorList.appendChild(li);
                });
            });

            errorContainer.hidden = false;
            successContainer.hidden = true;

        })
        .catch(error => {
            console.error('Ошибка:', error);
            errorList.innerHTML = '';

            const li = document.createElement('li');
            li.textContent = 'Не удалось отправить сообщение. Попробуйте позже.';
            errorList.appendChild(li);

            errorContainer.hidden = false;
        })
        .finally(() => {
            submitButton.disabled = false;
            submitButton.textContent = 'Отправить';
            captchaImage.src = CAPTCHA_ENDPOINT + '?t=' + Date.now();
        });
}

function clearErrors() {
    const form = document.querySelector('.feedback__form');

    form.querySelectorAll('.' + ERROR_MSG_CLASS).forEach(error => {
        error.remove();
    });

    form.querySelectorAll('.' + ERROR_CLASSES.label).forEach(label => {
        label.classList.remove(ERROR_CLASSES.label);
    });

    form.querySelectorAll('.' + ERROR_CLASSES.border).forEach(field => {
        field.classList.remove(ERROR_CLASSES.border);
    });
}