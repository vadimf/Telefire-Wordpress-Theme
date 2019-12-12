<?php
/**
 * Template Name: Blog lobby
 * The template for displaying Blog page
 */

get_header(); 

$fields = get_fields();

$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : ( ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1 );
$posts_per_page = 7;

$args = array(
	'post_type' 		=> 'post',
	'orderby'			=> 'date',
	'posts_per_page' 	=> $posts_per_page,
	'paged' 			=> $paged,
	'order'				=> 'DESC',
);
$posts_object = new WP_Query($args);

?>

<div class="blog_slider">
	<?php get_template_part( 'template-parts/home', 'slider' ); ?>
</div><!-- .blog_slider -->

<div class="custom-container breadcrumbs_blog">
	<span property="itemListElement" typeof="ListItem">
		<a property="item" typeof="WebPage" title="Go to Telefire." href="<?php echo home_url(); ?>" class="home">
			<span property="name"><span class="enshow">Home</span><span class="heshow">עמוד הבית</span></span>
		</a>
		<meta property="position" content="1">
	</span>
</div><!-- .breadcrumbs -->

<main class="custom-container blog_wrap">

	<div class="row">

		<?php get_template_part( 'template-parts/post', 'sidebar-mobile' ); ?>		

		<div class="col-lg-9">

			<div class="blog_items">

			<?php if ($posts_object->posts) : ?>
				<?php if ($paged > 1): ?><div class="third_level_posts"><?php endif; ?>
				<?php foreach($posts_object->posts as $k => $single_post) : ?>
				 	<?php if ($k == 0 && $paged == 1) { ?>
				 	<div class="promoted_post">
						<div class="promoted_post_loop post_item">
							<p class="time"><?php echo get_the_time( 'j/n/Y', $single_post->ID ); ?></p>											
							<a href="<?php echo get_the_permalink($single_post->ID); ?>"><h2><?php echo get_the_title($single_post->ID); ?></h2></a>
							<div class="short_descr"><?php echo get_the_excerpt($single_post->ID); ?></div>
						</div>
					</div><!-- .promoted_post -->
				 	<?php } else if (($k == 1 || $k == 2) && $paged == 1) { ?>
				 	<?php if ($k == 1 && $paged == 1): ?><div class="row secondary_posts"><?php endif; ?>
					<div class="col-lg-6 col-md-6 col-sm-12 secondary_posts_loop post_item">
						<div class="secondary-post-inner">
							<div class="second_img_wrap"><a class="second_img" href="<?php echo get_the_permalink($single_post->ID); ?>"><img src="<?php echo get_the_post_thumbnail_url( $single_post->ID, 'full' ); ?>" alt="Image"></a>
							</div>
							<div class="second_text">
								<a href="<?php echo get_the_permalink($single_post->ID); ?>"><h2><?php echo get_the_title($single_post->ID); ?></h2></a>
								<div class="reading_minutes">
									<?php if( get_field('reading_minutes', $single_post->ID) ): ?>
										<p><i><img src="<?php bloginfo('template_url') ?>/assets/images/clock.png"></i> <?php the_field('reading_minutes', $single_post->ID); ?></p>
									<?php endif; ?>
								</div>
								<div class="short_descr"><p><?php echo get_the_excerpt($single_post->ID); ?></p></div>
							</div>
						</div>
					</div>
					<?php if ($k == 2 && $paged == 1): ?></div><?php endif; ?><!-- .secondary_posts -->
				 	<?php } else { ?>
				 	<?php if ($k == 3 && $paged == 1): ?><div class="third_level_posts"><?php endif; ?>
					<div class="third_level_post_loop post_item">

						<div class="img_loop">
							<a class="third_img" href="<?php echo get_the_permalink($single_post->ID); ?>"><img src="<?php echo get_the_post_thumbnail_url( $single_post->ID, 'full' ); ?>" alt="Image"></a>
						</div><!-- .img_loop -->
														
						<div class="col-lg-8 text_loop">
							<?php if( get_field('small_title', $single_post->ID) ): ?>
								<a href="<?php echo get_the_permalink($single_post->ID); ?>"><h4><?php the_field('small_title', $single_post->ID); ?></h4></a>
							<?php endif; ?>
							<a href="<?php echo get_the_permalink($single_post->ID); ?>">
								<h2><span class="time"><?php echo get_the_time('j.n.Y', $single_post->ID); ?></span> <?php echo get_the_title($single_post->ID); ?></h2>
							</a>
							<div class="short_descr"><?php echo get_the_excerpt($single_post->ID); ?></div>
						</div><!-- .text_loop -->
					</div>
					<?php if (($k == ($posts_per_page - 1) || $k == (count($posts_object->posts) - 1)) && $paged == 1): ?></div><?php endif; ?><!-- .third_level_posts -->
				 	<?php } ?>
				<?php endforeach; ?>
				<?php if ($paged > 1): ?></div><?php endif; ?>
			<?php endif; ?>
			
			<?php echo sac_pagination($posts_object); ?>

			</div><!-- .blog_items -->

		</div>

	<?php get_template_part( 'template-parts/post', 'sidebar' ); ?>

	</div><!-- .row -->

</main><!-- .blog_wrap -->

<?php get_template_part( 'template-parts/page', 'ctabanner' ); ?>

<?php get_footer(); ?>