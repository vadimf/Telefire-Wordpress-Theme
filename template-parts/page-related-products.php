<div class="custom-container related-products">
	<div class="text-center">
		<h3><?php echo get_field('related_title'); ?></h3>
	</div>

		

		<?php 

		$posts = get_field('products_list');

		if( $posts ): ?>
		    <div class="type_block row">
		    <?php foreach( $posts as $post): // variable must be called $post (IMPORTANT) ?>
		        <?php setup_postdata($post); ?>
		       

						<div class="col-lg-4 col-md-4 products_lobby_item">
							<div class="video_imgs">
								<a href="<?php echo the_permalink(); ?>">
									<?php the_post_thumbnail('products-lobby'); ?>									
								</a>
							</div>
							<div class="course_item_text">

								<a href="<?php the_permalink(); ?>"><h2><?php the_title(); ?></h2></a>
							</div>	
						</div>


		    <?php endforeach; ?>
		    </div>
		    <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
		<?php endif; ?>



</div>