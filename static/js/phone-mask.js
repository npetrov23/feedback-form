export function initPhoneMask() {
    const phone = document.querySelector('#phone');

    phone.addEventListener('input', () => {
        let digits = phone.value.replace(/\D/g, '');

        if (digits.startsWith('7') || digits.startsWith('8')) {
            digits = digits.slice(1);
        }

        digits = digits.slice(0, 10);

        let result = '+7';

        if (digits.length > 0) result += ' (' + digits.slice(0, 3);
        if (digits.length >= 4) result += ') ' + digits.slice(3, 6);
        if (digits.length >= 7) result += '-' + digits.slice(6, 8);
        if (digits.length >= 9) result += '-' + digits.slice(8, 10);

        phone.value = result;
    });
}