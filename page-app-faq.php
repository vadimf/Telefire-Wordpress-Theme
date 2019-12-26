<?php
/*
Template name: Application FAQ
*/
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php wp_title('|', true, 'right'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no">
    <link rel="shortcut icon" type="image/x-icon" href="/wp-content/uploads/favicon.png">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div class="library">
    <div class="library-content">
        <div class="custom-container">
            <?php
            $faqItems = new WP_Query(array(
                'post_type' => 'app_faq',
                'posts_per_page' => -1,
                'order' => 'ASC',
                'orderby' => 'menu_order'
            ));

            if ($faqItems->have_posts()):
                ?>
                <div class="faq">
                    <h2 class="page__subtitle">שאלות ותשובות</h2>

                    <div class="faq-list">
                        <?php while ($faqItems->have_posts()): $faqItems->the_post(); ?>
                            <div class="faq-list__item">
                                <h3 class="faq-list__title"><?php echo get_the_title() ?></h3>
                                <div class="faq-list__content"><?php the_content() ?></div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

</div>

<script type="application/javascript">
    const activeFaqItemClassName = 'faq-list__item--active';

    jQuery('.faq-list__item').on('click', '.faq-list__title', function () {
        const element = jQuery(this).parent();

        const wasOpen = element.hasClass(activeFaqItemClassName);

        jQuery('.faq-list__item.' + activeFaqItemClassName).removeClass(activeFaqItemClassName);

        if (! wasOpen) {
            element.addClass(activeFaqItemClassName);
        }
    });

    // Uncomment to open the first question by default
    // jQuery(document).ready(() => {
    //     jQuery('.faq-list__title')[0].click();
    // });
</script>

<?php wp_footer(); ?>

</body>
</html>
