<?php 
/*
Template name: Txt Template
*/


get_header();
$fields = get_fields();
$sidebar_group = get_field('sidebar', 'option');

?>


<div class="blog_slider">
	<?php get_template_part( 'template-parts/home', 'slider' ); ?>
</div><!-- .blog_slider -->


<div class="custom-container breadcrumbs_page">
	<?php if(function_exists('bcn_display'))
	{
	    bcn_display();
	}?>
</div><!-- .breadcrumbs -->

<main class="custom-container blog_wrap">
	<div class="row">
		<aside class="col-lg-3 sidebar sidebar-mobile">
			<div class="sidebar_top" style="background-image:url(<?php echo $sidebar_group['bg_sidebar']['url']; ?>">
				<span class="circle">
					<i class="fa fa-angle-down" aria-hidden="true"></i>	
				</span>
				<span><?php echo $sidebar_group['mobile_text']; ?></span>
			</div>
			<?php if (count($fields['links'])) : ?>
			<ul>
				<?php foreach($fields['links'] as $link) : ?>
				<li><a href="<?php echo $link['link']['url']; ?>" <?php if (isset($link['link']['target']) && !empty($link['link']['target'])) echo 'target="'. $link['link']['target'] .'"'; ?>><?php echo $link['link']['title']; ?></a></li>
				<?php endforeach; ?>
			</ul>
			<?php endif; ?>
		</aside><!-- .sidebar -->

		<div class="col-lg-9 main-content" data-aos="fade" data-aos-easing="ease-in" data-aos-delay="1200" data-aos-duration="800">
			<h1><?php the_title(); ?>

			<?php 
			the_content();
			?>

		</div><!-- .blog_items -->

		<aside class="col-lg-3 sidebar">
			<div class="sidebar_top" style="background-image:url(<?php echo $sidebar_group['bg_sidebar']['url']; ?>">
				 <img src="<?php echo $sidebar_group['icon_sidebar']['url']; ?>" alt="Icon" />
			</div>
			<?php if (count($fields['links'])) : ?>
			<ul>
				<?php foreach($fields['links'] as $link) : ?>
				<li><a href="<?php echo $link['link']['url']; ?>" <?php if (isset($link['link']['target']) && !empty($link['link']['target'])) echo 'target="'. $link['link']['target'] .'"'; ?>><?php echo $link['link']['title']; ?></a></li>
				<?php endforeach; ?>
			</ul>
			<?php endif; ?>
		</aside><!-- .sidebar -->

	</div><!-- .row -->
</main><!-- .blog_wrap -->

<?php get_template_part( 'template-parts/page', 'ctabanner' ); ?>


<?php 
	get_footer();
?>