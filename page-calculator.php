<?php
/*
Template name: Calculator
*/

get_header();
$fields = get_fields();
$sidebar_group = get_field('sidebar', 'option');

?>

<div class="calculator-page">
    <div class="blog_slider">
        <?php get_template_part('template-parts/home', 'slider'); ?>
    </div>

    <main class="custom-container">
        <h1 class="page__title"><?php the_title(); ?></h1>
        <div class="page__description"><?php the_content(); ?></div>

        <div class="calculator-page__iframe">
            <iframe src="<?php echo $fields['iframe_url']; ?>" id="calculator-iframe"></iframe>
        </div>
    </main>
</div>

<script type="application/javascript">
    const iframeElements = jQuery('#calculator-iframe');
    const calculatorWrapper = jQuery('.calculator-page__iframe').first()[0];
    const iframeElement = iframeElements[0];
    const bodyElement = jQuery('html,body');
    let iframeBody;

    iframeElements.load(() => {
        iframeBody = jQuery(iframeElement.contentWindow.document.body);

        adjustIframeHeight();

        iframeBody.find('button,a,img').click(adjustIframeHeight);
        iframeBody.on('click', 'button,a,img', adjustIframeHeight);
    });
    
    function adjustIframeHeight() {
        iframeElements.height(iframeElement.contentWindow.document.body.scrollHeight * 1.1);
    }

    window.addEventListener("message", receiveMessage, false);

    function receiveMessage(event) {
        switch (event.data) {
            case 'results_displayed':
                resultsDisplayed();
                break;
            case 'resize_window':
                adjustIframeHeight();
                break;
        }
    }

    function resultsDisplayed() {
        adjustIframeHeight();

        const resultsHeader = iframeBody.find('.results-header').first()[0];
        const resultsHeaderOffsetTop = (resultsHeader && resultsHeader.offsetTop) || 0;
        const mainHeader = jQuery('.main_header').first()[0];

        bodyElement.animate({
            scrollTop: calculatorWrapper.offsetTop + resultsHeaderOffsetTop - mainHeader.clientHeight
        }, 300);
    }
</script>

<?php
get_footer();
?>
