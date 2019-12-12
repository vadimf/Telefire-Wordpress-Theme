<div class="features-product">
	<div class="custom-container">
		<div class="text-center">
			<h3><?php echo get_field('features_title'); ?></h3>
		</div>




	<?php if(get_field('features_list')): ?>
		<div class="type_block row">
			
				<?php while(has_sub_field('features_list')): ?>
					<div class="col-lg-4 col-md-4 products_lobby_item ">
						<div class="course_item_text">
						<img src="<?php the_sub_field('icon'); ?>"><br />
						<h5><?php the_sub_field('title'); ?></h5>

						

						<?php

						// check if the repeater field has rows of data
						if( have_rows('lists') ):
						?>
						<ul>

						<?php 
						 	// loop through the rows of data
						    while ( have_rows('lists') ) : the_row();
						    	?>


						        
						        <li><?php the_sub_field('title'); ?> </li>

						    <?php 
						    endwhile;
						    ?>

						</ul>
						<?php
							endif;

						?>

						</div>
					</div>
				
				<?php endwhile; ?>
		 	
		</div> <!---.block -->
	<?php endif; ?>

	</div>
</div>