<?php
/**
 * The template for displaying single Blog page
 */

get_header(); 
the_post();

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
		<?php get_template_part( 'template-parts/post', 'sidebar-mobile' ); ?>	
		<div class="col-lg-9">
			<div class="blog_items single_blog">
				<div class="blog_icon clearfix">
					<?php if( $fields['icon_top'] ): ?>
						<img src="<?php echo $fields['icon_top']['url']; ?>" alt="Icon">
					<?php endif; ?>
					<?php if( $fields['title_top'] ): ?>
						<h3><?php echo $fields['title_top']; ?></h3>
					<?php endif; ?>
				</div>
				<p class="time"><?php the_time('j/n/Y'); ?></p>											
				<h1><?php the_title(); ?></h1>
				<div class="big_post_img">
					<?php if( $fields['image_content'] ): ?>
						<img src="<?php echo $fields['image_content']['url']; ?>" alt="<?php echo $fields['image_content']['alt']; ?>">
					<?php endif; ?>
				</div>
				<?php the_content(); ?>
			</div>
		</div><!-- .blog_items -->

	<?php get_template_part( 'template-parts/post', 'sidebar' ); ?>

	</div><!-- .row -->

</main><!-- .blog_wrap -->

<?php get_template_part( 'template-parts/page', 'ctabanner' ); ?>

<?php get_footer(); ?>