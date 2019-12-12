<div class="consultants__list">

    <?php
    if ($consultantsList->have_posts()) :
        while ($consultantsList->have_posts()) : $consultantsList->the_post();
            $shortDescription = get_post_meta($post->ID, "short_description", true);
            $role = get_post_meta($post->ID, "role", true);

            ?>
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

                <div class="consultants__item-about"><?php echo $shortDescription; ?></div>

                <a href="<?php the_permalink(); ?>" class="consultants__btn consultants__btn--info">למידע נוסף וקביעת
                    פגישה</a>
            </div>
        <?php
        endwhile;
    endif;
    ?>

</div>
