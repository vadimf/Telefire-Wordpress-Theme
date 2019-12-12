<?php
/**
 * Search template
 */

get_header(); 

$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : ( ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1 );

$posts_query_args = array(
	's' => get_search_query(),
	'post_type' => array( 'post', 'page', 'products' ),
	'orderby' => 'date',
	'posts_per_page' => '8',
	'paged' => $paged
);
$posts_query = new WP_Query( $posts_query_args );

?>

<div class="search-banner" style="background-image: url(<?php echo site_url(); ?>/wp-content/uploads/2018/05/slide1-1.jpg)">
	<div class="custom-container">
		<div class="banner-container">
			<p><?php printf( __( 'Search Results for: %s', 'exlibris' ), '<span>' . get_search_query() . '</span>' ); ?></p>
		</div>
	</div>
</div>
<main class="custom-container blog_wrap">
	<div class="row">			
		<div class="col-12">
		 <?php 
      	if ( $posts_query->have_posts() ) :
			/* Start the Loop */
			while ( $posts_query->have_posts() ) : $posts_query->the_post(); ?>

			<div class="third_level_posts">
				<div class="row third_level_post_loop post_item">
					<div class="col-lg-4 img_loop">
						<a class="third_img" href="<?php echo get_the_permalink(); ?>">
						<img src="<?php if (get_the_post_thumbnail_url( get_the_ID(), 'full' )) echo get_the_post_thumbnail_url( get_the_ID(), 'full' ); else echo home_url() . '/wp-content/uploads/2018/05/img6.jpg'; ?>" alt="Image"></a>
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
			</div>
			<?php endwhile; ?>
			<?php echo sac_pagination($posts_query); ?>
	  	<?php else : ?>
		<p class="search-empty"><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'exlibris' ); ?></p>
	  	<?php endif; ?>

		</div><!-- .blog_items -->
	</div><!-- .row -->
</main><!-- .blog_wrap -->

<?php get_footer(); ?>