export const ERROR_CLASSES = {
    'label': 'field-label--error',
    'border': 'field-border--error',
};

const MAX_LENGTH_INPUT = 255;
const MAX_LENGTH_TEXTAREA = 4096;
const IGNORED_FIELD_TYPES = ['hidden', 'submit'];

export function validate(data) {
    const errors = {};

    validateRequired(data.raw_data, errors);
    validateFieldLength(data.raw_data, errors);
    validatePhone(data, errors);
    validateEmail(data, errors);
    
    return errors;    
}

function validateRequired(data, errors) {
    for (const field of data.elements) {
        if (IGNORED_FIELD_TYPES.includes(field.type)) {
            continue;
        }

        if (field.required) {
            const isEmpty = field.type === 'checkbox'
                ? !field.checked
                : !field.value.trim();

            if (isEmpty) {
                addError(errors, field.name, 'Поле обязательно для заполнения');
            }
        }
    }
}

function validateFieldLength(data, errors) {
    for (const field of data.elements) {
        if (IGNORED_FIELD_TYPES.includes(field.type)) {
            continue;
        }

        if (!['INPUT', 'TEXTAREA'].includes(field.tagName)) {
            continue;
        }

        const valueLength = field.value.length;
        let maxLength = MAX_LENGTH_INPUT;

        if(field.tagName === 'TEXTAREA') {
            maxLength = MAX_LENGTH_TEXTAREA;
        }

        if(valueLength > maxLength) {
            addError(
                errors,
                field.name,
                `Максимальное количество символов: ${maxLength}`
            );
        }
    }
}

function validatePhone(data, errors) {
    const phone = data.phone;

    if (!phone || !phone.trim()) {
        return;
    }

    const phoneRegex = /^(?:\+7|7|8)\d{10}$/;

    if (!phoneRegex.test(phone.replace(/[\s()-]/g, ''))) {
        addError(errors, 'phone', 'Некорректный формат номера телефона');
    }
}

function validateEmail(data, errors) {
    const email = data.email;

    if (!email || !email.trim()) {
        return;
    }

    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    if (!emailRegex.test(email.trim())) {
        addError(errors, 'email', 'Некорректный формат электронной почты');
    }
}

function addError(errors, field, message) {
    if (!errors[field]) {
        errors[field] = [];
    }

    errors[field].push(message);
}