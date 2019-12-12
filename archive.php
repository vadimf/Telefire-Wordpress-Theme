<?php
/**
 * The template for displaying Archive posts page
 */

get_header(); 

$fields = get_fields();
?>

<div class="custom-container breadcrumbs_blog">
	<?php if(function_exists('bcn_display'))
	{
	    bcn_display();
	}?>
</div><!-- .breadcrumbs -->

<main class="custom-container blog_wrap">

	<div class="row">			

		<div class="col-lg-9 blog_items">

			<div class="third_level_posts">

				<?php
	                if(have_posts() ):
	                    while(have_posts() ): the_post();
	            ?>
					<div class="row third_level_post_loop post_item">

						<div class="col-lg-4 img_loop">
							<a class="third_img" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('full'); ?></a>
						</div><!-- .img_loop -->
														
						<div class="col-lg-8 text_loop">
							<?php if( get_field('small_title') ): ?>
								<a href="<?php the_permalink(); ?>"><h4><?php the_field('small_title'); ?></h4></a>
							<?php endif; ?>
							<a href="<?php the_permalink(); ?>">
								<h2><span class="time"><?php the_time('j.n.Y'); ?></span> <?php the_title(); ?></h2>
							</a>
							<div class="short_descr"><?php the_excerpt(); ?></div>
						</div><!-- .text_loop -->

					</div><!-- .third_level_post_loop -->
				
				<?php endwhile;	?>
				<?php else: ?>
				<?php endif;
					wp_reset_postdata();
				?>
				
			</div><!-- .third_level_posts -->

			<?php echo sac_pagination($wp_query); ?>

		</div><!-- .blog_items -->

	<?php get_template_part( 'template-parts/post', 'sidebar' ); ?>

	</div><!-- .row -->

</main><!-- .blog_wrap -->

<?php get_template_part( 'template-parts/page', 'ctabanner' ); ?>

<?php get_footer(); ?>