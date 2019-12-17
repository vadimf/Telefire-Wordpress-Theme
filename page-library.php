<?php
/*
Template name: Library
*/

get_header();

?>

<div class="library">
    <div class="library-page">
        <div class="custom-container">
            <h1 class="page__title"><?php the_title(); ?></h1>

            <div class="custom-tabs-panel">
                <?php
                $categories = get_terms(array(
                    'taxonomy' => 'library_category',
                    'hide_empty' => true,
                ));

                foreach ($categories as $category): ?>
                    <div class="custom-tabs-panel__item" data-id="<?php echo $category->term_id; ?>">
                        <div class="custom-tabs-panel__item-label">
                            <?php echo $category->name; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="library-content">
        <div class="custom-container">
            <?php
            $faqItems = new WP_Query(array(
                'post_type' => 'library_faq',
                'posts_per_page' => -1,
                'order' => 'ASC',
                'orderby' => 'menu_order'
            ));

            $videoItems = new WP_Query(array(
                'post_type' => 'guide_videos',
                'posts_per_page' => -1,
                'order' => 'ASC',
                'orderby' => 'menu_order'
            ));

            if ($faqItems->have_posts()):
                ?>
                <div class="faq">
                    <h2 class="page__subtitle">שאלות ותשובות</h2>

                    <div class="faq-list">

                        <?php
                        while ($faqItems->have_posts()):
                            $faqItems->the_post();
                            $itemCategories = get_the_terms($post, 'library_category');
                            $categoryIds = array_map(
                                function ($cat) {
                                    return $cat->term_id;
                                },
                                $itemCategories
                            )
                            ?>
                            <div class="faq-list__item<?php foreach ($categoryIds as $categoryId): ?> faq-list__item--category-<?php echo $categoryId; ?><?php endforeach; ?>">
                                <h3 class="faq-list__title"><?php echo get_the_title() ?></h3>
                                <div class="faq-list__content"><?php the_content() ?></div>
                            </div>
                        <?php endwhile; ?>

                    </div>
                </div>
            <?php endif; ?>

            <?php if ($videoItems->have_posts()): ?>
                <div class="videos">
                    <h2 class="page__subtitle">סרטוני הדרכה</h2>

                    <div class="video-list">

                        <?php
                        while ($videoItems->have_posts()):
                            $videoItems->the_post();
                            $itemCategories = get_the_terms($post, 'library_category');
                            $categoryIds = array_map(
                                function ($cat) {
                                    return $cat->term_id;
                                },
                                $itemCategories
                            );
                            $fields = get_fields();
                            $youtubeUrl = $fields['youtube_url'];
                            preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $youtubeUrl, $youtubeIds);
                            ?>
                            <div class="video-list__item<?php foreach ($categoryIds as $categoryId): ?> video-list__item--category-<?php echo $categoryId; ?><?php endforeach; ?>">
                                <div class="video-wrapper">
                                    <iframe src="https://www.youtube.com/embed/<?php echo $youtubeIds[1]; ?>?modestbranding=1"
                                            frameborder="0" allow="accelerometer; encrypted-media; picture-in-picture"
                                            allowfullscreen></iframe>
                                </div>
                                <h3 class="video-list__item-title"><?php echo get_the_title() ?></h3>
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
    const activeTabClassName = 'custom-tabs-panel__item--active';

    jQuery('.faq-list__item').on('click', '.faq-list__title', function () {
        const element = jQuery(this).parent();

        if (element.hasClass(activeFaqItemClassName)) {
            return;
        }

        jQuery('.faq-list__item.' + activeFaqItemClassName).removeClass(activeFaqItemClassName);
        element.addClass(activeFaqItemClassName);
    });

    jQuery('.custom-tabs-panel__item').on('click', '.custom-tabs-panel__item-label', function () {
        const element = jQuery(this).parent();

        if (element.hasClass(activeTabClassName)) {
            return;
        }

        jQuery('.faq-list__item, .video-list__item').hide();
        jQuery('.faq-list__item.' + activeFaqItemClassName).removeClass(activeFaqItemClassName);
        jQuery('.custom-tabs-panel__item.' + activeTabClassName).removeClass(activeTabClassName);

        element.addClass(activeTabClassName);

        const categoryId = element.data('id');
        const faqItemsUnderCategory = jQuery('.faq-list__item.faq-list__item--category-' + categoryId);
        const videoItemsUnderCategory = jQuery('.video-list__item.video-list__item--category-' + categoryId);
        const faqList = jQuery('.faq');
        const videoList = jQuery('.videos');

        if (!faqItemsUnderCategory.length) {
            faqList.hide();
        } else {
            faqList.show();
            faqItemsUnderCategory.show();
            jQuery(faqItemsUnderCategory[0]).find('.faq-list__title').click()
        }

        if (!videoItemsUnderCategory.length) {
            videoList.hide();
        } else {
            videoList.show();
            videoItemsUnderCategory.show();
        }
    });

    jQuery(document).ready(() => {
        jQuery('.custom-tabs-panel__item-label')[0].click();
    });
</script>

<?php
get_footer();
?>
