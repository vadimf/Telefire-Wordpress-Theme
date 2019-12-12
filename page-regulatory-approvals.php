<?php
/*
Template name: Regulatory approvals
*/

get_header();
?>

<div class="regulatory-approvals-page">
    <div class="custom-container">
        <h1 class="page__title"><?php the_title(); ?></h1>

        <div class="custom-tabs-panel">
            <?php
            $categories = $terms = get_terms(array(
                'taxonomy' => 'regulatory_approval_category',
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

<div class="regulatory-approvals">
    <div class="custom-container">
        <?php
        $analogItems = new WP_Query(array(
            'post_type' => 'regulatory_approval',
            'posts_per_page' => -1,
            'order' => 'ASC',
            'orderby' => 'menu_order',
            'meta_key' => 'hub_type',
            'meta_value' => 'analog'
        ));

        $regionalItems = new WP_Query(array(
            'post_type' => 'regulatory_approval',
            'posts_per_page' => -1,
            'order' => 'ASC',
            'orderby' => 'menu_order',
            'meta_key' => 'hub_type',
            'meta_value' => 'regional'
        ));

        if ($analogItems->have_posts()):
            ?>
            <div class="analog-hubs">
                <h2 class="page__subtitle">רכזות אנלוגיות</h2>

                <div class="pdf-files">
                    <?php
                    while ($analogItems->have_posts()) {
                        $analogItems->the_post();
                        $pdfFile = get_fields()['file'];
                        $itemCategories = get_the_terms($post, 'regulatory_approval_category');
                        $additionalClasses = array_map(
                            function ($cat) {
                                return 'pdf-files__item--category-' . $cat->term_id;
                            },
                            $itemCategories
                        );

                        include "pdf-file-row.php";
                    }
                    ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($regionalItems->have_posts()):
            ?>
            <div class="regional-hubs">
                <h2 class="page__subtitle">רכזות אזוריות</h2>

                <div class="pdf-files">
                    <?php
                    while ($regionalItems->have_posts()) {
                        $regionalItems->the_post();
                        $pdfFile = get_fields()['file'];
                        $itemCategories = get_the_terms($post, 'regulatory_approval_category');
                        $additionalClasses = array_map(
                            function ($cat) {
                                return 'pdf-files__item--category-' . $cat->term_id;
                            },
                            $itemCategories
                        );

                        include "pdf-file-row.php";
                    }
                    ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>


<script type="application/javascript">
    const activeTabClassName = 'custom-tabs-panel__item--active';

    jQuery('.custom-tabs-panel__item').on('click', '.custom-tabs-panel__item-label', function () {
        const element = jQuery(this).parent();

        if (element.hasClass(activeTabClassName)) {
            return;
        }

        const categoryId = element.data('id');

        jQuery('.pdf-files__item').hide();

        jQuery('.custom-tabs-panel__item.' + activeTabClassName).removeClass(activeTabClassName);
        element.addClass(activeTabClassName);

        const regionalItemsUnderCategory = jQuery('.regional-hubs .pdf-files__item--category-' + categoryId);
        const analogItemsUnderCategory = jQuery('.analog-hubs .pdf-files__item--category-' + categoryId);

        console.log(analogItemsUnderCategory);

        const regionalList = jQuery('.regional-hubs');
        const analogList = jQuery('.analog-hubs');

        if (!regionalItemsUnderCategory.length) {
            regionalList.hide();
        } else {
            regionalList.show();
            regionalItemsUnderCategory.show();
        }

        if (!analogItemsUnderCategory.length) {
            analogList.hide();
        } else {
            analogList.show();
            analogItemsUnderCategory.show();
        }
    });

    jQuery(document).ready(() => {
        jQuery('.custom-tabs-panel__item-label')[0].click();
    });
</script>

<?php
include "pdf-file-modal.php";
get_footer();
?>
