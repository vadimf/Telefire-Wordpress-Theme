jQuery('.wpcf7-form-control-wrap').each(function () {
    const children = jQuery(this.children);
    const className = this.className.replace('wpcf7-form-control-wrap ', '');

    children.each(function () {
        this.classList.add(className);
    });

    children.unwrap();
});

document.addEventListener('wpcf7invalid', (event) => {
    if (
        !event ||
        !event.detail ||
        !event.detail.apiResponse ||
        !event.detail.apiResponse.invalidFields ||
        !event.detail.apiResponse.invalidFields.length
    ) {
        return;
    }

    jQuery('.form-field').each(function () {
        jQuery(this)
            .removeClass('form-field--error')
            .find('.form-field-label__error').text('');
    });

    const {invalidFields} = event.detail.apiResponse;

    invalidFields.forEach((invalidField) => {
        const {into, message} = invalidField;
        const className = into.replace('span.wpcf7-form-control-wrap', 'wpcf7-form-control');

        const element = jQuery('.' + className)[0];
        const parentElement = jQuery(element.parentNode);

        parentElement.addClass('form-field--error');
        parentElement.find('.form-field-label__error').text(message);
    })
})
