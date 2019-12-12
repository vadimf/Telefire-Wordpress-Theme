<?php
/**
 * The template for displaying the front page
 */

get_header(); 
?>

<?
while ( have_posts() ) : the_post();

$fields = get_fields();

if ( isset($fields['slide']) && is_array($fields['slide']) ):
	//intialize the active class
  	$liActive = ' class="active"';
  	$indicators = '';
  	foreach ($fields['slide'] as $k => $field):
    	$format = '<li data-target="#carouselFront" data-slide-to="%s"%s></li>';
    	$indicators .= sprintf($format, $k, $liActive);
    	$liActive = '';
    endforeach;
endif;

if ( isset($fields['slide']) && is_array($fields['slide']) ):
  //intialize the active class
  $liActive = ' class="active"';
  $itActive = ' active';
  //$indicators = '';
  $items = '';
  foreach ($fields['slide'] as $k => $field):

    ob_start();

    $style = '';
    if( isset($field['bg_image']['url']) ) {
      $format = ' style="background-image: url(%s)"';
      $style = sprintf($format, $field['bg_image']['url']);
    }

    ?>
    <div class="carousel-item<?php echo $itActive ?>"<?php echo $style ?>>
      <div class="custom-container first">
        <div class="slider-text is-animated-in">

        </div>
      </div>
    </div>
    <?php

    $items .= ob_get_contents();
    ob_end_clean();


    //reset the active class
    $liActive = '';
    $itActive = '';
  endforeach;
  endif;
?>
<div class="carousel-front">
	<div id="carouselFront" class="carousel slide home-slider carousel-sync" data-ride="carousel" data-pause="false" data-interval="5000">
		<?php if( count($fields['slide']) > 1 ): ?>
	  	<ol class="carousel-indicators">
	    	<?php echo $indicators ?>
	  	</ol>
	  	<?php endif; ?>
	  	<div class="carousel-inner">
	    	<?php echo $items ?>
	  	</div>
	  	<div class="clearfix"></div>
	  	<div class="content-over-slider">
	  		<div class="our-products">
				<div class="custom-container second">
					<div class="our-products-inner">
						<h2><?php echo get_field('our_producst_title'); ?></h2>
						<div class="row">
							<div class="categories-list">

							<?php
								$key = 1;
							    while ( have_rows('our_producst_category') ) : the_row();
							?>
								 <style>
								  	a .cat-icon<?php echo $key; ?> {
								        width: 140px;
								        height: 150px;
								        background: url("<?php echo get_sub_field('category_icon'); ?>") no-repeat;
								        display: inline-block;
			        			        -webkit-transition: all 0.5s ease 0s;
								        transition: all 0.5s ease 0s;
								    }
								    a:hover .cat-icon<?php echo $key; ?> {
								        background: url("<?php echo get_sub_field('category_icon_active'); ?>") no-repeat;
								    }

								    .active a .cat-icon<?php echo $key; ?> {
								        background: url("<?php echo get_sub_field('category_icon_active'); ?>") no-repeat;
								    }
								    @media only screen and (max-width: 520px) {
								    	a .cat-icon<?php echo $key; ?> {
									        width: 100%;
											height: 100px;
											background-size: contain;
											background-position: center;
									    }
									    a:hover .cat-icon<?php echo $key; ?> {
									    	background-size: contain;
											background-position: center;
									    }
								    }
								 </style>

                                <div class="item id<?php echo $key; ?>">

									<a href="<?php echo get_sub_field('link'); ?>">
										<div class="cat-icon<?php echo $key; ?>"></div>
										<h3 class="title">
											<?php echo get_sub_field('title'); ?>
										</h3>
										<img class="shop-cat-icon hover" src="<?php echo get_sub_field('category_icon_active'); ?>" alt="Icon">
									</a>
								</div>


							<?php
								$key++;
							    endwhile;
							?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="custom-container third">
				<div class="quick-news-inner">
					<div class="quick-news">

						<div class="col-md-12">
							<div class="category-news-all">
								<div class="btn btn-arrow btn-arrow-left btn-danger btn-outline">
									<span><?php echo get_field('category_news_title'); ?></span>
								</div>
							</div>
							<div class="category-news-carousel">
								<div id="carouselCategoryNews" class="carousel slide" data-ride="carousel" data-interval="6000">
									<div class="carousel-inner">
									  	<?php

									  		$key=1;
									  			while(has_sub_field('category_news')): ?>
									    		<div class="carousel-item <?php if($key==1) { echo'active';} ?>">
									     		<a href="<?php the_sub_field('link'); ?>"><?php the_sub_field('title'); ?></a>
									    		</div>
										<?php
											$key++;
											endwhile; ?>
									</div>
									<div class="carousel-control-tools">
										<a class="carousel-control-prev slider-link" href="#carouselCategoryNews" role="button" data-slide="prev">
										    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
										    <span class="sr-only">Previous</span>
										</a>
										<a class="carousel-control-next slider-link" href="#carouselCategoryNews" role="button" data-slide="next">
										    <span class="carousel-control-next-icon" aria-hidden="true"></span>
										    <span class="sr-only">Next</span>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php include('companies-search.php'); ?>
	  	</div>
	</div>

	<?php
//	endif;

	if ( isset($fields['slide']) && is_array($fields['slide']) ):
		//intialize the active class
	  	$liActive = ' class="active"';
	  	$indicators = '';
	  	foreach ($fields['slide'] as $k => $field):
	    	$format = '<li data-target="#carouselFront2" data-slide-to="%s"%s></li>';
	    	$indicators .= sprintf($format, $k, $liActive);
	    	$liActive = '';
	    endforeach;
	endif;

	if ( isset($fields['slide']) && is_array($fields['slide']) ):
	  //intialize the active class
	  $liActive = ' class="active"';
	  $itActive = ' active';
	  //$indicators = '';
	  $items = '';
	  foreach ($fields['slide'] as $k => $field):

	    ob_start();

	    ?>
	    <div class="carousel-item<?php echo $itActive ?>">
	      <div class="custom-container fourth">
	        <div class="slider-text is-animated-in">
	        	<div class="row">
	        		<div class="col-xl-6 col-lg-6 col-md-12 slider-text-section">
	        			<h1 class="heading" data-aos="fade" data-aos-easing="ease-in" data-aos-delay="1000" data-aos-duration="500" ><span><?php echo $field['title_1'] ?></span><br><span><?php echo $field['title_2'] ?></span></h1>
				        <div class="subtitle subheading" data-aos="fade" data-aos-easing="ease-in" data-aos-delay="1200" data-aos-duration="500">
				            <?php if (!empty($field['text'])): ?><h2><?php echo $field['text'] ?></h2><?php endif; ?>
				        </div>
	        		</div>
	        		<div class="col-xl-6 col-lg-6 col-md-12 front-product-image">
	        		<?php if (isset($field['product_image']['url'])) : ?>
	        			<img src="<?php echo $field['product_image']['url']; ?>" alt="<?php echo $field['product_image']['alt']; ?>">
	        		<?php endif; ?>
	        		</div>
	        	</div>
	        </div>
	      </div>
	    </div>
	    <?php

	    $items .= ob_get_contents();
	    ob_end_clean();


	    //reset the active class
	    $liActive = '';
	    $itActive = '';
	  endforeach;
	?>
	<div id="carouselFront2" class="carousel slide home-slider carousel-sync" data-ride="carousel" data-pause="false" data-interval="5000">
		<?php if( count($fields['slide']) > 1 ): ?>
	  	<ol class="carousel-indicators">
	    	<?php echo $indicators ?>
	  	</ol>
		<?php endif; ?>
	  	<div class="carousel-inner">
	    	<?php echo $items ?>
	  	</div>
	  	<div class="clearfix"></div>
	</div>

	<?php endif; ?>
</div>

<div class="container-fluide video-bg" style="background: url('<?php echo get_field('video_bg_image'); ?>'); background-position: center center; background-size: cover;">*/
	<div class="video-content">
        <h2><?php echo get_field('video_title'); ?></h2>
		<h3><?php echo get_field('video_subtitle'); ?></h3>
		<a class="video pulse" href="<?php echo get_field('video_id'); ?>" data-fancybox><img src="<?php echo get_template_directory_uri();?>/assets/images/video-play-btn.png"></a>
	</div>
</div>

<!-- You need to know -->
<div class="container-fluide section-need-know" style="background: url('<?php echo get_field('we_need_know_image_bg'); ?>') center center; background-repeat: no-repeat; background-size: cover;">*/
<div class="custom-container fifth">
    <h2 class="ntktitle"><?php echo get_field('need_title'); ?></h2>
		<!-- Articles -->
		<div class="">
			<div class="need-know-content">

				<ul>

				<?php
				$k = 1;
				if( have_rows('need_articles') ):
				    while ( have_rows('need_articles') ) : the_row();
					if ($k <= 3) :
				?>
					<li class="item">
						<div class="need-know-box">
						<a href="<?php echo get_sub_field('link'); ?>">
							<div class="img-article need-know-img" style="background: url('<?php echo get_sub_field('image'); ?>') no-repeat; background-size: cover; height: 185px; background-position:center;*/
								transition: all 1s ease;
							  -moz-transition: all 1s ease;
							  -ms-transition: all 1s ease;
							  -webkit-transition: all 1s ease;
							  -o-transition: all 1s ease;">
                            <img src="<?php echo get_sub_field('image'); ?>" alt="Image" class="show-on-mobile">
							</div>
						</a>
						</div>
						<div class="description">
							<span><?php echo get_sub_field('info'); ?></span>
							<a href="<?php echo get_sub_field('link'); ?>"><h4><?php echo get_sub_field('title'); ?></h4></a>
							<p><?php echo get_sub_field('desc'); ?></p>
							<a href="<?php echo get_sub_field('link'); ?>" class="read-more"><?php echo get_sub_field('text_link'); ?></a>
						</div>
					</li>

				<?php
					$k++;
					endif;
				    endwhile;
				endif;
				?>
				<div class="clearfix"></div>
				</ul>

			</div>
		</div>

		<!-- Compliance standard  block -->

		<h3><?php echo get_field('title_standarts'); ?></h3>
		<div class="standarts">

			<?php

			$posts = get_field('standarts_icon');

			if( $posts ): ?>

			    <?php foreach( $posts as $post): // variable must be called $post (IMPORTANT) ?>
			        <?php setup_postdata($post); ?>
			        	<img src="<?php echo get_the_post_thumbnail_url(); ?>" title="<?php the_title(); ?>" alt="<?php the_title(); ?>">
			    <?php endforeach; ?>

			    <?php wp_reset_postdata(); ?>
			<?php endif; ?>

		</div>

		<!-- End Compliance standard block -->

		<!-- Contacts Us block -->
		<?php get_template_part( 'template-parts/page', 'cta-contacts-us' ); ?>
		<!-- End Contacts Us block -->
	</div>
</div>
<!-- End You need to know -->

<?php

endwhile; // End of the loop.

get_footer();
