<?php
/**
 * Template Name: Telefire_MobileAPP
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
	<?php $image = get_field('banner');

if( !empty($image) ): ?>

	<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />

<?php endif; ?>
</div><!-- .blog_slider -->

<div class="custom-container breadcrumbs_blog">
	
</div><!-- .breadcrumbs -->
<div class="main_page">
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
						
							<?php the_field('title');?>
						
						<h3 class="tt"><?php the_field('subtitle');?></h3> 
      
          
          <div class="background-red">
          <h1> <?php the_field('background-red');?></h1></div>
      <div class="background-blue"><h2> <?php the_field('background-blue');?></h2></div>
          <div class="image-heading"><h3> <?php the_field('image-heading');?></h3></div>
						</div>
					</div><!-- .promoted_post -->
				 	<?php } else if (($k == 1 || $k == 1) && $paged == 1) { ?>
				 	<?php if ($k == 1 && $paged == 1): ?><div class="row secondary_posts"><?php endif; ?>
				 	<img  class="upper-mobile"src="<?php the_field('upper_mobile');?>">
					<div class="col-lg-12 col-md-12 col-sm-12 secondary_posts_loop post_item">
					<div class="second-block">
							<?php
 
// check if the repeater field has rows of data
                       if( have_rows('repeater') ):

 	// loop through the rows of data
       while ( have_rows('repeater') ) : the_row();?>
       <div class="first-block">
            <?php $image = get_sub_field('image_1');
             $content = get_sub_field('title_1');?>

         
            <img src="<?php echo $image ?>" alt="<?php echo $image['alt'] ?>" />
              <h4><?php echo $content ?></h4>
               </div>
			  <?php
			 
           endwhile;

                    endif;

                     ?>
                
                     <?php 

         $link = get_field('link');

            if( $link ): ?>
						<a class="button" href="<?php echo $link; ?>"><?php the_field('orange-image');?></a>
				
						<?php endif; ?>
						</div>
						
					</div>
					<?php if ($k == 1 && $paged == 1): ?>
					
					</div><?php endif; ?><!-- .secondary_posts -->
				 	
					<div class="mobile-last">
				  
					<div class="lower-mobile">
                  <?php 

                      $image = get_field('mobile-image');

                      if( !empty($image) ): ?>

              	<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />

                  <?php endif; ?>
                  </div>
                  <div class="title-mobile">
                  <ul>
                      <li><h4><?php the_field('title-mobile');?></h4></li>
                   <li><h3><?php the_field('subtitle-mobile1');?></h3></li>
                   <li><h3><?php the_field('subtitle-mobile2');?></h3></li>
                   
                           <?php 
                           $link_new = get_field('link_1');

         if( $link_new ): ?>
						<a href="<?php echo $link_new; ?>"> <li><h3><?php the_field('subtitle-mobile3');?></h3></li></a>
				
						<?php endif; ?>
                       </ul>
                       <h2><?php the_field('tele-title');?></h2>
                       <h4><?php the_field('tele-sub');?></h4>




</div>

</div>
				
					<!-- .third_level_posts -->
				 	<?php } ?>
				<?php endforeach; ?>
				<?php if ($paged > 1): ?></div><?php endif; ?>
			<?php endif; ?>
			
			<?php echo sac_pagination($posts_object); ?>

			</div><!-- .blog_items -->

		</div>

	<?php get_template_part( 'template-parts/post', 'sidebar' ); ?>

	</div><!-- .row -->
	<?php get_template_part( 'template-parts/page', 'ctabanner' ); ?>

</main><!-- .blog_wrap -->
</div>


<?php get_footer(); ?>