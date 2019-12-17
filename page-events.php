<?php
/*
Template name: Events
*/

$fields = get_fields();

get_header();
?>
<div class="events">
    <div class="blog_slider blog_slider--bright">
        <?php get_template_part('template-parts/home', 'slider'); ?>
    </div><!-- .blog_slider -->

    <div class="events__tabs">
        <div class="custom-container">
            <div class="custom-tabs-panel custom-tabs-panel--multiselect">
                <div class="custom-tabs-panel__item" data-id="all">
                    <div class="custom-tabs-panel__item-label">
                        כל ההדרכות
                    </div>
                </div>

                <?php
                $categories = $terms = get_terms(array(
                    'taxonomy' => 'event_category',
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

    <?php
    $date_now = date('Y-m-d H:i:s');

    $eventsList = new WP_Query(array(
        'post_type' => 'events',
        'posts_per_page' => -1,
        'meta_key' => 'event_date',
        'orderby' => 'meta_value',
        'order' => 'ASC',
        'meta_query' => array(
            array(
                'key' => 'event_date',
                'compare' => '>=',
                'value' => $date_now,
                'type' => 'DATETIME',
            ),
        )
    ));

    if ($eventsList->have_posts()):
        ?>
        <div class="custom-container">
            <div class="events-list">
                <?php
                $existingEventTitles = [];
                while ($eventsList->have_posts()) : $eventsList->the_post();
                    if (in_array(get_the_title(), $existingEventTitles)) {
                        continue;
                    }

                    $existingEventTitles[] = get_the_title();

                    $fields = get_fields();
                    $eventDate = $fields['event_date'];
                    $eventFrom = $fields['event_from'];
                    $eventTo = $fields['event_to'];

                    $eventCategories = get_the_terms($post, 'event_category');
                    ?>
                    <a href="<?php echo get_the_permalink(); ?>"
                       class="events-list__item<?php foreach ($eventCategories as $category): ?> events-list__item--category-<?php echo $category->term_id; endforeach; ?>">
                        <h2 class="events-list__title"><?php echo get_the_title(); ?></h2>
                        <div class="events-list__description">
                            <?php echo get_the_excerpt(); ?>
                        </div>
                        <div class="events-list__date">
                            <div class="events-list__date-icon">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/globalbit/calendar-white-icon.png"
                                     alt="<?php echo get_the_title(); ?>" class="events-list__date-icon-image">
                            </div>
                            <div class="events-list__date-day"><?= $eventDate ?></div>
                            <div class="events-list__date-time"><?= $eventFrom ?>-<?= $eventTo ?></div>
                        </div>
                        <div class="events-list__tags">
                            <?php foreach ($eventCategories as $category): ?>
                                <span class="events-list__tag"><? echo $category->name ?></span>
                            <?php endforeach; ?>
                        </div>
                    </a>
                <?php endwhile; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<script type="application/javascript">
    const activeTabClassName = 'custom-tabs-panel__item--active';

    const tabs = jQuery('.custom-tabs-panel__item');
    const allTab = tabs.first();
    const allItems = jQuery('.events-list__item');
    let selectedCategories = [];

    function displayAllItems() {
        allItems.show();
    }

    function displayItemsByCategory(categoryId) {
        jQuery(`.events-list__item.events-list__item--category-${categoryId}`).show();
    }

    tabs.on('click', '.custom-tabs-panel__item-label', function () {
        const element = jQuery(this).parent();
        const categoryId = element.data('id');

        jQuery('.custom-tabs-panel__item.' + activeTabClassName).removeClass(activeTabClassName);
        allItems.hide();

        if (categoryId === 'all') {
            selectedCategories = [];
        } else {
            if (selectedCategories.includes(categoryId)) {
                selectedCategories = selectedCategories.filter((displayedCategory) => displayedCategory !== categoryId);
            } else {
                selectedCategories.push(categoryId);
            }

            selectedCategories.forEach((displayedCategory) => {
                displayItemsByCategory(displayedCategory);
                jQuery(`.custom-tabs-panel__item[data-id=${displayedCategory}]`).addClass(activeTabClassName);
            });
        }

        if (!selectedCategories.length) {
            displayAllItems();
            allTab.addClass(activeTabClassName);
        }
    });

    jQuery(document).ready(() => {
        jQuery('.custom-tabs-panel__item-label')[0].click();
    });
</script>

<?php
get_footer();
?>
