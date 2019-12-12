<?php
/*
Template name: Planning
*/

$fields = get_fields();

$childrenPages = new WP_Query(array(
    'post_type' => 'page',
    'posts_per_page' => -1,
    'post_parent' => $post->ID,
    'order' => 'ASC',
    'orderby' => 'menu_order'
));

get_header();
?>

<div class="planning">
    <?php if ($childrenPages->have_posts()): ?>
        <div class="planning-calculators">
            <div class="custom-container">
                <div class="planning__title">
                    <div class="planning__title-image-wrapper">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/globalbit/calc-icon.png"
                             class="planning__title-image"
                             alt="מחשבונים לתכנון מבנים"/>
                    </div>

                    <h2 class="planning__title-label">מחשבונים לתכנון מבנים</h2>
                </div>

                <div class="planning-calculators__wrapper">
                    <?php while ($childrenPages->have_posts()): $childrenPages->the_post(); ?>
                        <div class="planning-calculators__item">
                            <a href="<?php echo get_the_permalink() ?>">
                                <?php if (has_post_thumbnail()): ?>
                                    <div class="planning-calculators__item-image-container">
                                        <?php the_post_thumbnail('post-thumbnail', ['class' => 'planning-calculators__item-image', 'alt' => get_the_title()]); ?>
                                    </div>
                                <?php endif; ?>

                                <div class="planning-calculators__item-details">
                                    <h2 class="planning-calculators__item-title"><?php echo get_the_title() ?></h2>
                                </div>
                            </a>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php

    $revitFiles = new WP_Query(array(
        'post_type' => 'revit_file',
        'posts_per_page' => -1,
        'order' => 'ASC',
        'orderby' => 'menu_order'
    ));

    $pdfFiles = new WP_Query(array(
        'post_type' => 'pdf_document',
        'posts_per_page' => -1,
        'order' => 'ASC',
        'orderby' => 'menu_order'
    ));

    if ($revitFiles->have_posts() && $pdfFiles->have_posts()):
        ?>
        <div class="planning-downloads">
            <div class="custom-container">
                <div class="planning__title">
                    <div class="planning__title-image-wrapper">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/globalbit/download-icon.png"
                             class="planning__title-image"
                             alt="הורדות"/>
                    </div>

                    <h2 class="planning__title-label">הורדות</h2>
                </div>

                <?php if ($revitFiles->have_posts()): ?>
                    <h2 class="page__subtitle page__subtitle--upperline">קבצי REVIT</h2>

                    <div class="revit-files">
                        <?php
                        while ($revitFiles->have_posts()) :
                            $revitFiles->the_post();
                            $revitFile = get_fields()['revit_file'];
                            ?>
                            <div class="revit-files__item">
                                <a href="<?php echo $revitFile; ?>" target="_blank">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/globalbit/revit-icon.png"
                                         alt="<?php echo get_the_title(); ?>" class="revit-files__image">
                                </a>
                                <a href="<?php echo $revitFile; ?>" target="_blank"
                                   class="revit-files__label"><?php echo get_the_title() ?></a>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>

                <?php if ($pdfFiles->have_posts()): ?>
                    <h2 class="page__subtitle page__subtitle--upperline">כתב כמויות ומפרט</h2>

                    <div class="pdf-files">

                        <?php
                        while ($pdfFiles->have_posts()) {
                            $pdfFiles->the_post();
                            $pdfFile = get_fields()['file'];

                            include "pdf-file-row.php";
                        } ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php
include "pdf-file-modal.php";
get_footer();
?>
