<?php

$allEventsPostName = 'הדרכות';
$allEventsPostsItems = get_posts(array(
    'name' => $allEventsPostName,
    'post_type' => 'page',
    'post_status' => 'publish',
    'numberposts' => 1
));

$fields = get_fields($allEventsPostsItems[0]->ID);

if (isset($fields['slide']) && isset($fields['slide'][0])) {
    $fields['slide'][0]['title'] = get_the_title();
    unset($fields['slide'][0]['subtitle']);
    $fields['slide'][0]['terms'] = get_the_terms($post, 'event_category');
}

get_header();

$currentEventFields = get_fields();
$contactFormId = $currentEventFields['contact_form'];

?>

<div class="event">
    <div class="blog_slider blog_slider--bright">
        <?php get_template_part('template-parts/home', 'slider'); ?>
    </div><!-- .blog_slider -->

    <div class="event-details">
        <div class="custom-container">

            <div class="event-details__date">
                <div class="event-details__date-icon">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/globalbit/calendar-color-icon.png"
                         alt="תאריך האירוע" class="event-details__date-icon-image"/>
                </div>
                <div class="event-details__date-day"><?php echo $currentEventFields['event_date']; ?></div>
                <div class="event-details__date-time"><?php echo $currentEventFields['event_from']; ?>
                    -<?php echo $currentEventFields['event_to']; ?></div>
            </div>

            <div class="event-details__location">
                <div class="event-details__location-icon">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/globalbit/location-icon.png"
                         alt="מיקום האירוע" class="event-details__location-icon-image"/>
                </div>

                <div class="event-details__location-label<?php if (!$currentEventFields['location']): ?> event-details__location-label--unknown<?php endif; ?>">
                    <?php echo $$currentEventFields['location'] ? $currentEventFields['location'] : 'מיקום יעודכן בקרוב'; ?>
                </div>
            </div>

        </div>
    </div>

    <div class="custom-container">
        <div class="event-content">
            <?php the_content(); ?>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="event-form" id="contact-form">
                    <div class="event-form__content event-form__content--unsent">
                        <h3 class="event-form__heading">הרשמה להדרכה</h3>
                        <?php echo do_shortcode('[contact-form-7 id="' . $contactFormId . '" event-name="' . get_the_title() . '" event-date="' . $currentEventFields['event_date'] . '"]'); ?>
                    </div>

                    <div class="event-form__content event-form__content--sent">
                        <h3 class="event-form__heading">תודה על ההרשמה!</h3>
                        <p>
                            נציגי טלפייר יצרו איתך קשר ב-24 שעות
                            הקרובות כדי לקדם את תהליך ההרשמה.
                        </p>

                        <p>
                            נשמח לראותך בהדרכה הקרובה!
                        </p>

                        <p>
                            בברכה,
                            צוות טלפייר
                        </p>

                        <img src="<?php echo get_field('setting_logo', 'option'); ?>" alt="<?php echo get_bloginfo() ?>" />
                    </div>
                </div>
            </div>

            <?php
            $date_now = date('Y-m-d H:i:s');

            $eventsList = new WP_Query(array(
                'post__not_in' => [get_the_ID()],
                'title' => get_the_title(),
                'post_type' => 'events',
                'posts_per_page' => 6,
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
                <div class="col-lg-4">
                    <div class="additional-events">
                        <h3 class="additional-events__heading">תאריכים נוספים של ההדרכה</h3>

                        <div class="additional-events__list">

                            <?php
                            while ($eventsList->have_posts()):
                                $eventsList->the_post();
                                $eventFields = get_fields();
                                ?>
                                <a href="<?php echo get_the_permalink() ?>" class="additional-events__item">
                                    <div class="additional-events__date">
                                        <div class="additional-events__date-day"><?php echo $eventFields['event_date']; ?></div>
                                        <div class="additional-events__date-time"><?php echo $eventFields['event_from']; ?>
                                            -<?php echo $eventFields['event_to']; ?></div>
                                    </div>

                                    <div class="additional-events__location<?php if (!$eventFields['location']): ?> additional-events__location--unknown<?php endif; ?>">
                                        <?php echo $eventFields['location'] ? $eventFields['location'] : 'מיקום יעודכן בקרוב'; ?>
                                    </div>
                                </a>
                            <?php endwhile; ?>

                        </div>
                    </div>

                </div>

            <?php endif; ?>
        </div>
    </div>
</div>

<?php
get_footer();
?>

<script type="application/javascript">
    document.addEventListener('wpcf7mailsent', () => {
        const element = document.getElementById('contact-form');

        if (element) {
            element.classList.add('event-form--sent');
        }
    }, false);
</script>

<script type="application/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/js/custom-contact-form.handler.js"></script>
