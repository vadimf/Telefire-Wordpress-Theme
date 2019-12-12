<?php
/*
Template name: Contacts
*/
get_header();

$fields = get_fields();

?>

<div class="blog_slider">

	<?php get_template_part( 'template-parts/home', 'slider' ); ?>

</div>




<div class="custom-container breadcrumbs">
	<?php if(function_exists('bcn_display'))
	{
	    bcn_display();
	}?>

</div><!-- .breadcrumbs -->



<main class="custom-container blog_wrap">

	<div class="row">
		<div class="col-lg-9 col-md-12 contact-content">
			<h1><?php the_title(); ?></h1>

			<?php echo do_shortcode($fields['shortcode']); ?>
		</div>
		


		<?php get_template_part( 'template-parts/page', 'sidebar' ); ?>



	</div>
	<?php 
	the_content();
	?>
	</div>


</main>


<?php get_template_part( 'template-parts/page', 'ctabanner' ); ?>



<?php
	
	get_footer();

?>