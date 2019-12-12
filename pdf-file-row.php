<?php
global $pdfFile;
global $additionalClasses;

if (! $additionalClasses) {
    $additionalClasses = [];
}
?>
<div class="pdf-files__item<?php echo count($additionalClasses) > 0 ? ' ' . implode(' ', $additionalClasses) : '' ?>">
    <h3 class="pdf-files__title"><?php echo the_title() ?></h3>

    <?php if (has_post_thumbnail()): ?>
        <a href="<?php echo $pdfFile ?>" class="pdf-files__image-wrapper view-pdf"
           target="_blank" data-image="<?php echo get_the_post_thumbnail_url() ?>">
            <?php the_post_thumbnail('post-thumbnail', ['class' => 'pdf-files__image', 'alt' => get_the_title()]); ?>
        </a>
    <?php endif; ?>

    <div class="pdf-files__options">
        <a href="<?php echo $pdfFile; ?>" target="_blank"
           class="pdf-files__btn pdf-files__btn--view view-pdf"
           data-image="<?php echo get_the_post_thumbnail_url() ?>">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/globalbit/view-icon.png"
                 class="pdf-files__btn-icon"/>
            <span class="pdf-files__btn-label">צפיה</span>
        </a>

        <a href="<?php echo $pdfFile; ?>" target="_blank"
           class="pdf-files__btn pdf-files__btn--download" download>
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/globalbit/download-icon.png"
                 class="pdf-files__btn-icon"/>
            <span class="pdf-files__btn-label">הורדה</span>
        </a>
    </div>
</div>
