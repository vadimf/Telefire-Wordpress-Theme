jQuery(() => {
    const $ = jQuery;

    const tabs = $('.calculator-tabs__tab');

    tabs.on('click', function (event) {
        const $target = $(this);

        if ($target.hasClass('active')) {
            return;
        }

        tabs.removeClass('active');
        $target.addClass('active');
    })
});