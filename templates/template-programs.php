<?php
/**
 * Template Name: Programs
 * The template for displaying Programs page
 */

get_header(); 
while ( have_posts() ) : the_post();

$fields = get_fields();
?>
<!-- 
    <?php //print_r($fields); ?>
-->

<?php get_template_part( 'template-parts/home', 'slider' ); ?>
<div id="primary" class="content-area">
  	<main id="main" class="site-main">
  		<a class="learn-more-blue button blue apply-form mobile-fixed" href="#"><span class="text">Apply now</span></a>
	  	<div id="section1">
	  		<div class="custom-container left-menu">
	  			<div class="row">
	  				<div class="col-lg-4 col-md-12">
	  					<div class="left-sidebar sticky_left_sidebar">
			  				<ul>
		  					<?php if ($fields['menu_items'] && count($fields['menu_items'])) : ?>
		  						<?php foreach($fields['menu_items'] as $key => $item): ?>
			  					<li>
			  						<a href="#<?php echo $item['link']; ?>"><?php echo $item['text']; ?></a>
			  						<?php if ($key == 0): ?>
			  						<span>
			  							<i class="fa fa-long-arrow-down" aria-hidden="true"></i>
			  							<i class="fa fa-long-arrow-up" aria-hidden="true"></i>
			  						</span>
			  						<?php endif; ?>
			  					</li>
			  					<?php endforeach; ?>
			  				<?php endif; ?>
			  				</ul>
			  				<div class="apply-button">
			  					<a class="learn-more-blue button blue apply-form" href="#"><span class="text">Apply</span><span class="apply-overlay"></span></a>
			  				</div>
			  			</div>
	  				</div>
	  				<div class="col-lg-8 col-md-12" data-aos="fade" data-aos-easing="ease-in" data-aos-delay="200" data-aos-duration="1000">
							<?php if (get_field("1_pre_headline")): ?>
								<div class="pre-headline"><?the_field("1_pre_headline");?></div>
							<?php endif; ?>
							
	  					<div class="headline">
		  					<?php echo $fields['1_headline']; ?>
		  				</div>
		  				<?php if(!empty($fields['1_text_before_list'])) : ?>
		  				<p class="text-before-list"><?php echo $fields['1_text_before_list']; ?></p>
		  				<?php endif; ?>
		  				<?php if(is_array($fields['1_list_items']) && count($fields['1_list_items'])) : ?>
		  				<ul class="bullets">
		  					<?php foreach($fields['1_list_items'] as $field): ?>
		  					<li><?php echo $field['text']; ?></li>
		  					<?php endforeach; ?>
		  				</ul>
		  				<?php endif; ?>
		  				<?php if(!empty($fields['1_text_after_list'])) : ?>
		  				<p class="text-after-list"><?php echo $fields['1_text_after_list']; ?></p>
		  				<?php endif; ?>
	  				</div>
	  			</div>
	  		</div>
	  	</div>
	  	<div id="section2" data-aos="fade" data-aos-easing="ease-in" data-aos-delay="200" data-aos-duration="1000">
	  		<div class="custom-container">
	  			<div class="row">
	  				<div class="col-lg-4 col-md-12"></div>
	  				<div class="col-lg-8 col-md-12">
	  					<div class="headline">
		  					<?php echo $fields['2_headline']; ?>
		  				</div>
		  				<div class="row cubes">
		  					<?php if(is_array($fields['2_items']) && count($fields['2_items'])) : ?>
		  					<?php foreach($fields['2_items'] as $field): ?>
		  					<div class="col-lg-6 col-md-12">
		  						<div class="section2-item">
		  							<?php if($field['image']['url']) : ?>
		  							<div class="main-image align-center">
		  								<img src="<?php echo $field['image']['url']; ?>" alt="<?php echo $field['image']['alt']; ?>">
		  							</div>
		  							<?php endif; ?>
		  							<div class="section2-block">
		  								<?php if($field['icon']['url']) : ?>
			  							<img class="icon" src="<?php echo $field['icon']['url']; ?>" alt="Icon">
			  							<?php endif; ?>
			  							<p class="name"><?php echo $field['name']; ?></p>
			  							<p class="subtitle"><?php echo $field['subtitle']; ?></p>
			  							<p class="text"><?php echo $field['text']; ?></p>
		  							</div>
		  						</div>
		  					</div>
		  					<?php endforeach; ?>
		  					<?php endif; ?>
		  				</div>
	  				</div>
	  			</div>
	  		</div>
	  	</div>
	  	<div id="section3" data-aos="fade" data-aos-easing="ease-in" data-aos-delay="200" data-aos-duration="1000">
	  		<div class="custom-container">
	  			<div class="row">
	  				<div class="col-lg-4 col-md-12"></div>
	  				<div class="col-lg-8 col-md-12">
	  					<div class="headline">
		  					<?php echo $fields['3_headline']; ?>
		  				</div>
		  				<div class="cubes">
		  				<?php if(is_array($fields['3_items']) && count($fields['3_items'])) : ?>
		  					<?php foreach($fields['3_items'] as $field): ?>
  							<?php echo $field['text_before_list']; ?>
  							<?php if(is_array($field['list']) && count($field['list'])) : ?>
  							<ul class="bullets">
  								<?php foreach($field['list'] as $item): ?>
  								<li><?php echo $item['text']; ?></li>
  								<?php endforeach; ?>
  							</ul>
		  					<?php endif; ?>
		  					<?php endforeach; ?>
		  				<?php endif; ?>
		  				</div>
		  				<a class="learn-more-blue button blue align-center" href="<?php echo $fields['3_cta_link']['url']; ?>" <?php if (!empty($fields['3_cta_link']['target'])) echo 'target="'. $fields['3_cta_link']['target'] .'"'; ?>><span class="text"><?php echo $fields['3_cta_text']; ?></span><span class="apply-overlay"></span></a>
	  				</div>
	  			</div>
	  		</div>
	  	</div>
	  	<div id="section4" data-aos="fade" data-aos-easing="ease-in" data-aos-delay="200" data-aos-duration="1000">
	  		<div class="custom-container">
	  			<div class="row">
	  				<div class="col-lg-4 col-md-12"></div>
	  				<div class="col-lg-8 col-md-12">
	  					<div class="headline">
		  					<?php echo $fields['4_headline']; ?>
		  				</div>
		  				<div class="row cubes">
		  					<?php if(is_array($fields['4_items']) && count($fields['4_items'])) : ?>
		  					<?php foreach($fields['4_items'] as $k => $field): ?>
		  					<div class="main-box">
		  						<div class="section4-item">
		  							<?php if($field['icon']['url']) : ?>
		  							<img class="icon" src="<?php echo $field['icon']['url']; ?>" alt="Icon">
		  							<?php endif; ?>
		  							<p class="name"><?php echo $field['1st_line']; ?></p>
		  							<p class="subtitle"><?php echo $field['2nd_line']; ?></p>
		  							<p class="text"><?php echo $field['text']; ?></p>
		  						</div>
		  					</div>
		  					<?php if ($k < 2): ?>
		  					<div class="arrow-right align-center">
		  						<img src="<?php echo home_url(); ?>/wp-content/uploads/2018/03/course-structure-arrow-right.png" alt="Arrow">
		  					</div>
		  					<?php endif;?>
		  					<?php endforeach; ?>
		  					<?php endif; ?>
		  				</div>
	  				</div>
	  			</div>
	  		</div>
	  	</div>
	  	<div id="section5" data-aos="fade" data-aos-easing="ease-in" data-aos-delay="200" data-aos-duration="1000">
	  		<div class="custom-container">
	  			<div class="row">
	  				<div class="col-lg-4 col-md-12"></div>
	  				<div class="col-lg-8 col-md-12">
	  					<div class="headline">
		  					<?php echo $fields['5_headline']; ?>
		  				</div>
		  				<div class="row cubes">
		  					<?php if(is_array($fields['5_items']) && count($fields['5_items'])) : ?>
		  					<?php foreach($fields['5_items'] as $field): ?>
		  					<div class="col-lg-6 col-md-12">
		  						<div class="section2-item">
		  							<?php if($field['image']['url']) : ?>
		  							<div class="main-image align-center">
		  								<img src="<?php echo $field['image']['url']; ?>" alt="<?php echo $field['image']['alt']; ?>">
		  							</div>
		  							<?php endif; ?>
		  							<div class="section2-block">
			  							<p class="name"><?php echo $field['name']; ?></p>
			  							<p class="subtitle"><?php echo $field['subtitle']; ?></p>

											<div class="teacher-icons">
												<?php if ($field['linkedin'] != "") : ?>
													<a href="<?php echo $field['linkedin']; ?>" target=_blank><img src="/wp-content/uploads/2018/04/linkedin_black.png" class="teacher-icon-black" /></a>
													<a href="<?php echo $field['linkedin']; ?>" target=_blank><img src="/wp-content/uploads/2018/04/linkedin_white.png" class="teacher-icon-white" /></a>
												<?php endif; ?>
												<?php if ($field['email'] != "") : ?>
													<a href="<?php echo $field['email']; ?>" target=_blank><img src="/wp-content/uploads/2018/04/mail_black.png" class="teacher-icon-black" /></a>
													<a href="<?php echo $field['email']; ?>" target=_blank><img src="/wp-content/uploads/2018/04/mail_white.png" class="teacher-icon-white" /></a>
												<?php endif; ?>
											</div>

		  							</div>
		  						</div>
		  					</div>
		  					<?php endforeach; ?>
		  					<?php endif; ?>
		  				</div>
	  				</div>
	  			</div>
	  		</div>
	  	</div>
	  	<div id="section6" data-aos="fade" data-aos-easing="ease-in" data-aos-delay="200" data-aos-duration="1000">
	  		<div class="custom-container">
	  			<div class="row">
	  				<div class="col-lg-4 col-md-12"></div>
	  				<div class="col-lg-8 col-md-12">
	  					<div class="headline">
		  					<?php echo $fields['6_headline']; ?>
		  				</div>
		  				<div class="text">
		  					<?php echo $fields['6_text']; ?>
		  				</div>
	  				</div>
	  			</div>
	  		</div>
	  	</div>
	  	<div id="section7" data-aos="fade" data-aos-easing="ease-in" data-aos-delay="200" data-aos-duration="1000">
	  		<div class="custom-container">
	  			<div class="row">
	  				<div class="col-lg-4 col-md-12"></div>
	  				<div class="col-lg-8 col-md-12">
	  					<div class="headline">
		  					<?php echo $fields['7_headline']; ?>
		  				</div>
		  				<div class="text">
		  					<?php echo $fields['7_text']; ?>
		  				</div>
	  				</div>
	  			</div>
	  			<div class="section7-images">
	  				<?php foreach($fields['7_images'] as $image): ?>
	  				<div class="image-container">
	  					<img src="<?php echo $image['image']['url']; ?>" alt="<?php echo $image['image']['alt']; ?>">
	  				</div>
	  				<?php endforeach; ?>
	  			</div>
	  		</div>
	  	</div>
			<?php if ($fields['8_headline'] != ""): ?>
	  	<div id="section8" data-aos="fade" data-aos-easing="ease-in" data-aos-delay="200" data-aos-duration="1000">
	  		<div class="custom-container">
	  			<div class="row">
	  				<div class="col-lg-4 col-md-12"></div>
	  				<div class="col-lg-8 col-md-12">
	  					<div class="headline">
		  					<?php echo $fields['8_headline']; ?>
		  				</div>
		  				<div class="text">
		  					<?php echo $fields['8_text']; ?>
		  				</div>
	  				</div>
	  			</div>
	  		</div>
	  	</div>
			<?php endif; ?>
	  	<div id="section9" data-aos="fade" data-aos-easing="ease-in" data-aos-delay="200" data-aos-duration="1000">
	  		<div class="custom-container">
	  			<div class="row">
	  				<div class="col-lg-4 col-md-12"></div>
	  				<div class="col-lg-8 col-md-12">
	  					<div class="headline">
		  					<?php echo $fields['9_headline']; ?>
		  				</div>
		  				<div class="cubes">
		  					<?php foreach($fields['9_items'] as $field): ?>
		  					<div class="cube-item-text">
								<div class="cohorts-item-column">
									<p class=""><?php echo $field['column_1']; ?></p>
								</div>
								<div class="cohorts-item-column">
									<p class=""><?php echo $field['column_2']; ?></p>
								</div>
								<div class="cohorts-item-column">
									<p class=""><?php echo $field['column_3']; ?></p>
								</div>
								<div class="cohorts-item-column last-block">
									<p class=""><?php echo $field['column_4_price']; ?></p>
								</div>
								<!-- <div class="clearfix on-mobile"></div> -->
								<div class="cohorts-item-cta">
									<a class="learn-more-blue button blue" href="<?php echo $field['cta_link']['url']; ?>" <?php if (!empty($field['cta_link']['target'])) echo 'target="'. $field['cta_link']['target'] .'"'; ?>><span class="text"><?php echo $field['cta_text']; ?></span><span class="apply-overlay"></span></a>
								</div>
			  				</div>
		  					<?php endforeach; ?>
			  			</div>
							<?php the_field("9_paragraph_last"); ?>
	  				</div>
	  			</div>
	  		</div>
	  	</div>
	  	<div id="section10" data-aos="fade" data-aos-easing="ease-in" data-aos-delay="200" data-aos-duration="1000">
	  		<div class="custom-container">
	  			<div class="row">
	  				<div class="col-lg-4 col-md-12"></div>
	  				<div class="col-lg-8 col-md-12">
	  					<div class="headline">
		  					<?php echo $fields['10_headline']; ?>
		  				</div>
		  				<div class="question-list">
						  	<?php foreach($fields['10_list'] as $question): ?>
						  	<div class="question-item">
						  		<p class="question-item-title">
						  			<span class="quesion-text"><?php echo $question['question']; ?></span>
						  			<span class="question-arrow"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></span>
						  		</p>
						  		<div class="question-answer">
						  			<?php echo $question['answer']; ?>
						  		</div>
						  	</div>
						  	<?php endforeach; ?>
						</div>
	  				</div>
	  			</div>
	  		</div>
	  	</div>
  	</main><!-- #main -->
</div><!-- #primary -->


<?php
endwhile; // End of the loop.

get_footer();