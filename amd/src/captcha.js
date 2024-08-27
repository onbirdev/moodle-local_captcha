import $ from "jquery";

export const init = (captchaBaseUrl, captchaInputName) => {
    $(`input[name="${captchaInputName}"]`).val('');

    $(document).on('click', '.captcha-refresh .btn', (e) => {
        const time = new Date().getTime();
        let url = `${captchaBaseUrl}?t=${time}`;
        $('.captcha-image img').attr('src', url);
        e.preventDefault();
    });
};
