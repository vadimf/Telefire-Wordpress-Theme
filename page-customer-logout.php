<?php
/*
Template name: Customer LogOut page
*/
	get_header();
	wp_set_current_user(0);
?>

<div class="custom-container">
	<div class="row woocommerce-account-page">	

			<div class="col-md-12">

				<div class="col-md-8 waiting-approve-messages">

					<div class="telefire-auth-form">
						<div class="head-form">
							<h2><?php echo get_field('page_logout_title'); ?></h2>
						</div>

						<p><?php echo get_field('page_logout_messages'); ?></p>
					</div>
				</div>


				
			</div>

		

		<?php 	
			the_content();
			?>

	</div>
</div>

<?php 
	get_footer();
?>