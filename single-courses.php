<?php

/**

 * The template for displaying single course page

 */



get_header(); 

the_post();



$fields = get_fields();



// To get fields from Theme settings

$titles = get_field('course_details_titles', 'option');

$register_group = get_field('register_button', 'option');

$reg_title_main = $register_group['register_label'];

$reg_bg_main = $register_group['register_bg'];

$reg_color_main = $register_group['register_color'];



$reg_title = ($fields['register_label']) ? $fields['register_label'] : $reg_title_main;

$reg_bg = ($fields['register_bg']) ? $fields['register_bg'] : $reg_bg_main;

$reg_color = ($fields['register_color']) ? $fields['register_color'] : $reg_color_main;



$additional_title = ($fields['add_title']) ? $fields['add_title'] : $titles['add_title'];

$image = get_field('play_icon', 'option');



$modal_form = get_field('modal_form', 'option');

$form_bg = $modal_form['form_bg'];



?>



<div class="blog_slider">

	<?php get_template_part( 'template-parts/home', 'slider' ); ?>

</div><!-- .blog_slider -->



<div class="custom-container breadcrumbs_blog">

	<?php if(function_exists('bcn_display'))

	{

	    bcn_display();

	}?>

</div><!-- .breadcrumbs -->



<main class="custom-container course_wrap">



	<div class="">			



		<div class="col-lg-9 single_course">



			<?php if (!empty($fields['course_date'])): ?><div class="row details_row">

				<div class="col-lg-4 col-md-6 col-6"><h5><?php echo $titles['course_date_title'] ?><h5></div>

				<div class="col-lg-8 col-md-6 col-6"><h4><?php echo $fields['course_date'] ?><h4></div>				

			</div><?php endif; ?>



			<?php if (!empty($fields['course_place'])): ?><div class="row details_row">

				<div class="col-lg-4 col-md-6 col-6"><h5><?php echo $titles['course_place_title'] ?><h5></div>

				<div class="col-lg-8 col-md-6 col-6"><h4><?php echo $fields['course_place'] ?><h4></div>				

			</div><?php endif; ?>



			<?php if (!empty($fields['course_hours'])): ?><div class="row details_row">

				<div class="col-lg-4 col-md-6 col-6"><h5><?php echo $titles['course_hours_title'] ?><h5></div>

				<div class="col-lg-8 col-md-6 col-6"><h4><?php echo $fields['course_hours'] ?><h4></div>				

			</div><?php endif; ?>



			<?php if (!empty($fields['for_whom'])): ?><div class="row details_row">

				<div class="col-lg-4 col-md-6 col-6"><h5><?php echo $titles['for_whom_title'] ?><h5></div>

				<div class="col-lg-8 col-md-6 col-6"><h4><?php echo $fields['for_whom'] ?><h4></div>				

			</div><?php endif; ?>



			<?php if (!empty($fields['cost_member'])): ?><div class="row details_row">

				<div class="col-lg-4 col-md-6 col-6"><h5><?php echo $titles['cost_member_title'] ?><h5></div>

				<div class="col-lg-8 col-md-6 col-6"><h4><?php echo $fields['cost_member'] ?><h4></div>				

			</div><?php endif; ?>



			<?php if (!empty($fields['cost_participant'])): ?><div class="row details_row">

				<div class="col-lg-4 col-md-6 col-6"><h5><?php echo $titles['cost_participant_title'] ?><h5></div>

				<div class="col-lg-8 col-md-6 col-6"><h4><?php echo $fields['cost_participant'] ?><h4></div>				

			</div><?php endif; ?>



		</div><!-- .single_course  -->

		

	</div><!-- .row -->



</main><!-- .course_wrap -->



<div class="custom-container course_reg" style="background-color:<?php echo $reg_color; ?>; background-image:url(<?php echo $reg_bg['url']; ?>)">

		<button type="button" data-toggle="modal" data-target="#myModal" class=""><?php echo $reg_title; ?></button>



			<div id="myModal" class="modal fade" role="dialog">

				<div class="modal-dialog">

					<div class="modal-content">

						<button type="button" class="close" data-dismiss="modal"><i class="fa fa-times close-icon"></i></button>

						<div class="modal_header" style="background-image:url(<?php echo $form_bg['url']; ?>)"><h4><?php echo $modal_form['form_title']; ?> </h4></div>

						<?php echo do_shortcode('[contact-form-7 id="546" title="Courses registration"]'); ?>

					</div>

				</div>

			</div>

		

</div><!-- .course_reg -->	



<div class="custom-container additional_courses">

	

	<?php

	$post_objects = get_field('additional_course');



	if( $post_objects ): ?>



		<h3><?php echo $additional_title; ?></h3>



		<div class="row">



		    <?php foreach( $post_objects as $post): 

		    	setup_postdata($post); 

		    ?>



				<div class="col-lg-4 course_item">

					<div class="video_imgs">

						<a class="video" data-fancybox href="<?php echo the_field('video'); ?>">

							<?php the_post_thumbnail('full'); ?>

							<img class="play" src="<?php echo $image['url'] ?>">

						</a>

					</div>

					<div class="course_item_text">

						<p class="time"><?php echo get_the_time('j.n.Y'); ?></p>

						<a href="<?php echo get_the_permalink(); ?>"><h2><?php the_title(); ?></h2></a>

					</div>	

				</div><!-- .course_item -->



		    <?php endforeach; ?>



	    </div>



	    <?php wp_reset_postdata(); ?>

	<?php endif; ?>

</div>

<script type="text/javascript">
//wpcf7-submit on Course page
jQuery("#wpcf7-f546-p8780-o1").on( 'wpcf7:submit', function( event ){
    console.log( 'Register form - Course page: <?php the_title(); ?>');
    dataLayer.push({'Category':'training','Action':'submit','Label':'<?php the_title(); ?>' ,'event':'auto_event'});
    console.log( dataLayer );
} );
</script>

<?php get_footer(); ?>