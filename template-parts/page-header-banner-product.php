<?php $big_image = get_field('big_img'); ?>
<div class="header-product-banner" style="background: url('<?php echo get_field('product_header_bg'); ?>');  background-repeat: no-repeat;
    background-size: cover;
    min-height: 480px;">
	<div class="custom-container">
		<div class="row">
			<div class="col-md-7 product-desc">
		
			<h1><?php the_title(); ?></h1>
			<p class="short-desc">

				<?php echo get_field('short_desc'); ?>

			</p>
			<div class="product_buttons">
				<?php
				$download_button_3_link = get_field('download_button_3_link');
				$download_button_3_text = get_field('download_button_3_text');
				 if (!empty($download_button_3_link) && !empty($download_button_3_text)) : ?>
				<a href="<?php echo get_field('download_button_3_link'); ?>" id="download_button_3_link" class="btn-telefire2" download><span><?php echo get_field('download_button_3_text'); ?></span></a>

				<script type="text/javascript">
					//Single product - downloading technical material Link 3
					jQuery("#download_button_3_link").click(function() {	
						
						console.log('Single product - downloading technical material Link: <?php echo get_field('download_button_3_text'); ?>');

						dataLayer.push({'Category':'<?php the_title(); ?>','Action':'download','Label':'<?php echo get_field('download_button_3_text'); ?>' ,'event':'auto_event'});
						console.log(dataLayer);

					}); 
				</script>
				<?php endif; ?>
				<?php 
				$download_button_2_link = get_field('download_button_2_link');
				$download_button_2_text = get_field('download_button_2_text');
				if (!empty($download_button_2_link) && !empty($download_button_2_text)) : ?>
				<a href="<?php echo get_field('download_button_2_link'); ?>" id="download_button_2_link" class="btn-telefire2" download><span><?php echo get_field('download_button_2_text'); ?></span></a>

				<script type="text/javascript">
					//Single product - downloading technical material Link 3
					jQuery("#download_button_2_link").click(function() {	
						
						console.log('Single product - downloading technical material Link: <?php echo get_field('download_button_2_text'); ?>');

						dataLayer.push({'Category':'<?php the_title(); ?>','Action':'download','Label':'<?php echo get_field('download_button_2_text'); ?>' ,'event':'auto_event'});
						console.log(dataLayer);

					}); 
				</script>
				<?php endif; ?>
				<?php 
				$download_button_1_link = get_field('download_button_1_link');
				$download_button_1_text = get_field('download_button_1_text');
				if (!empty($download_button_1_link) && !empty($download_button_1_text)) : ?>
				<a href="<?php echo get_field('download_button_1_link'); ?>" id="download_button_1_link" class="btn-telefire2" download><span><?php echo get_field('download_button_1_text'); ?></span></a>
				<script type="text/javascript">
					//Single product - downloading technical material Link 3
					jQuery("#download_button_1_link").click(function() {	
						
						console.log('Single product - downloading technical material Link: <?php echo get_field('download_button_1_text'); ?>');

						dataLayer.push({'Category':'<?php the_title(); ?>','Action':'download','Label':'<?php echo get_field('download_button_1_text'); ?>' ,'event':'auto_event'});
						console.log(dataLayer);

					}); 
				</script>
				<?php endif; ?>
			</div>
			</div>
			<div class="col-md-5 product-image">
				<img src="<?php echo $big_image['url']; ?>" alt="<?php echo $big_image['alt']; ?>">
			</div>
		</div>


	</div>
</div>