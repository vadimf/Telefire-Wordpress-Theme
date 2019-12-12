<?php
/*
Template name: Consulting and planning
*/

$fields = get_fields();
$sidebar_group = get_field('sidebar', 'option');
$childrenPages = new WP_Query(array(
    'post_type' => 'page',
    'posts_per_page' => -1,
    'post_parent' => $post->ID,
    'order' => 'ASC',
    'orderby' => 'menu_order'
));

get_header();

?>


<div class="blog_slider blog_slider--bright">
    <?php get_template_part('template-parts/home', 'slider'); ?>
</div><!-- .blog_slider -->


<div class="consulting-planning">

    <?php
    if ($childrenPages->have_posts()):
        ?>
        <div class="consulting-planning__wrapper">
            <div class="custom-container">

                <?php
                while ($childrenPages->have_posts()):
                    $childrenPages->the_post();
                    $shortDescription = get_post_meta(get_the_ID(), 'short_description', true);
                    ?>
                    <div class="consulting-planning__item">
                        <a href="<?php echo get_the_permalink() ?>">
                            <?php if (has_post_thumbnail()): ?>
                                <div class="consulting-planning__item-image-container">
                                    <?php the_post_thumbnail('post-thumbnail', ['class' => 'consulting-planning__item-image', 'alt' => get_the_title()]); ?>
                                </div>
                            <?php endif; ?>

                            <div class="consulting-planning__item-details">
                                <h2 class="consulting-planning__item-title"><?php echo get_the_title() ?></h2>
                                <p class="consulting-planning__item-subtitle"><?php echo $shortDescription ?></p>
                            </div>
                        </a>
                    </div>
                <?php
                endwhile;
                ?>

            </div>
        </div>
    <?php
    endif;
    ?>

</div>

<div class="consultants main-content">
    <div class="custom-container">

        <div class="consultants__data">
            <h2>בואו לפגוש את היועצים שלנו</h2>
            <?php the_content(); ?>
        </div>

        <?php
        $consultantsList = new WP_Query(array(
            'post_type' => 'consultant',
            'posts_per_page' => -1,
            'order' => 'ASC',
            'orderby' => 'menu_order'
        ));
        include "consultants-list.php"
        ?>
    </div>
</div>


<?php
get_footer();
?>
