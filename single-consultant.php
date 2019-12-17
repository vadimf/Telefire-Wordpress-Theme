<?php
get_header();
$fields = get_fields();
$role = $fields['role'];
$contactFormId = $fields['contact-form'];
?>

<div class="blog_slider blog_slider--bright">
    <?php get_template_part('template-parts/home', 'slider'); ?>
</div><!-- .blog_slider -->

<div class="custom-container">
    <div class="consultant-full">
        <div class="row">
            <div class="col-lg-<?= $contactFormId ? 8 : 12 ?>">
                <div class="consultants__item">
                    <div class="consultants__header">
                        <?php if (has_post_thumbnail()) { ?>
                            <div class="consultants__item-image-wrapper">
                                <?php the_post_thumbnail('post-thumbnail', ['class' => 'consultants__item-image', 'alt' => get_the_title()]); ?>
                            </div>
                        <?php } ?>

                        <div class="consultants__details">
                            <div class="consultants__item-name"><?php echo get_the_title(); ?></div>
                            <div class="consultants__item-title"><?php echo $role; ?></div>
                        </div>
                    </div>

                    <div class="consultants__item-about"><?php the_content(); ?></div>
                </div>
            </div>

            <?php if ($contactFormId): ?>
                <div class="col-lg-4">
                    <div class="consultant-contact-form" id="contact-form">
                        <div class="consultant-contact-form__form">
                            <h2 class="consultant-contact-form__title">קביעת פגישה עם
                                <b><?php echo get_the_title(); ?></b></h2>
                            <?php echo do_shortcode('[contact-form-7 id="' . $contactFormId . '" title="consultant-contact-form" page-name="' . get_the_title() . '"]'); ?>
                        </div>
                        <div class="consultant-contact-form__form-sent">
                            <h2 class="consultant-contact-form__title">תודה על הפנייה!</h2>

                            <p>נציגי טלפייר יצרו איתך קשר<br/>
                                ב-24 שעות הקרובות<br/>
                                כדי לקדם את התהליך.</p>

                            <p>בברכה,<br/>
                                צוות טלפייר</p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php
    $consultantsList = new WP_Query(array(
        'post_type' => 'consultant',
        'post__not_in' => [get_the_ID()],
        'posts_per_page' => -1,
        'order' => 'ASC',
        'orderby' => 'menu_order'
    ));

    if ($consultantsList->have_posts()):
        ?>

        <div class="consultants main-content">
            <div class="custom-container">

                <div class="consultants__data">
                    <h2>עוד יועצים שלנו</h2>
                </div>

                <?php
                include "consultants-list.php"
                ?>
            </div>
        </div>

    <?php
    endif;
    ?>
</div>

<script type="application/javascript">
    document.addEventListener('wpcf7mailsent', () => {
        const element = document.getElementById('contact-form');

        if (element) {
            element.classList.add('consultant-contact-form--sent');
        }
    }, false);
</script>

<script type="application/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/js/custom-contact-form.handler.js"></script>

<?php
get_footer();
?>
