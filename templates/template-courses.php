<?php

/**

 * Template Name: Courses Lobby

 * The template for displaying Courses Lobby page

 */



get_header(); 



$fields = get_fields();

$taxonomies = get_terms('type');

usort($taxonomies, 'sac_sort_terms_by_description');

$image = get_field('play_icon', 'option');



$taxonomies_reversed = array_reverse($taxonomies);



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



<main class="custom-container courses_wrap">



<div class="top_taxonomies clearfix">



<?php

foreach ( $taxonomies_reversed as $taxonomy ) {

	$icons_links = get_field('icons_links', $taxonomy);

?>



<a class="top_taxonomy" href="#category-<?php echo $taxonomy->term_id ?>"><img src="<?php echo $icons_links['url']; ?>"/><?php echo $taxonomy->name ?></a>

<?php

	} //foreach 

?>



</div>







<?php



	foreach ( $taxonomies_reversed as $taxonomy ) {

		$args = array(

			'post_type' => 'courses',

			'orderby' => 'date', 

			'order' => 'DESC',

			'tax_query' => array(

				array(

					'taxonomy' => 'type',

					'terms'    => $taxonomy->term_id

				)

			)

		);



		$icons_title = get_field('icons_title', $taxonomy);



		$loop = new WP_Query( $args );

		if ( $loop->have_posts() ) { ?>



		<?php $k=1;  ?>



			<div class="type_block row" id="<?php echo 'category-'. $taxonomy->term_id; ?>">

				 				

				<div class="tax_header">

					<h2 class="tax_name"><img src="<?php echo $icons_title['url']; ?>"/><?php echo $taxonomy->name ?></h2>

				</div>

				

				<?php while ( $loop->have_posts() ) { $loop->the_post(); ?>



						<div class="col-lg-4 col-md-6 course_item <?php if ($k <= 9 ) echo 'visible'; else echo 'hidden'; ?>">

							<div class="course-item-outer">

								<div class="video_imgs">

									<a class="video <?php if (!empty(get_field('download_file_link'))){ ?> item-id-<?php the_ID(); ?><?php } ?>" <?php if (!empty(get_field('video'))) {echo 'data-fancybox';} else if (!empty(get_field('download_file_link'))) echo "download"; else if (!empty(get_field('open_url_link'))) echo "open"; ?> href="<?php if (!empty(get_field('video'))) {echo the_field('video');} else if (!empty(get_field('download_file_link'))) echo get_field('download_file_link'); else if (!empty(get_field('open_url_link'))) echo get_field('open_url_link'); else echo get_permalink(); ?>"


										
										<?php /*

										<?php the_title(); ?>
										*/ ?>

										>

										<?php the_post_thumbnail('full'); ?>

										<?php if (!empty(get_field('video'))) : ?>

										<img class="play" src="<?php echo $image['url'] ?>">

										<?php endif; ?>

									</a>

								</div>

								<div class="course_item_text">

									<p class="time"><?php echo get_the_time('j.n.Y'); ?></p>

									<a class="<?php if (!empty(get_field('download_file_link'))){ ?> item-id-<?php the_ID(); ?><?php } ?>" <?php if (!empty(get_field('video'))) {echo 'data-fancybox';} else if (!empty(get_field('download_file_link'))) echo "download"; else if (!empty(get_field('open_url_link'))) echo "open"; ?> href="<?php if (!empty(get_field('video'))) {echo the_field('video');} else if (!empty(get_field('download_file_link'))) echo get_field('download_file_link'); else if (!empty(get_field('open_url_link'))) echo get_field('open_url_link'); else echo get_permalink(); ?>"
									   
									   ><h2><?php the_title(); ?></h2></a>

								</div>	

							</div>

						</div><!-- .course_item -->

						<script>
						jQuery(".item-id-<?php the_ID(); ?>").click(function () {
       					    
       						console.log('Course page - downloading technical material: <?php the_title(); ?>');            
                            dataLayer.push({'event': 'Click', 'Category':'academi','Action':'download','Label': '<?php the_title(); ?>' ,'event':'auto_event'});                            
                            console.log(dataLayer);						                             
						                             
						});
                        </script>						

						<?php $k++; ?>

				<?php } // end while 

				?>

				<?php if ($k > 9 ): ?>

				<div class="more_wrap"><a href="#" class="loadMore"><?php echo $fields['more_title']; ?></a></div>

				<?php endif; ?>

			</div>

		<?php } // end if



		wp_reset_postdata();	





	} //foreach 

?>



</main><!-- .courses_wrap -->



<?php get_template_part( 'template-parts/page', 'ctabanner' ); ?>



<?php get_footer(); ?>