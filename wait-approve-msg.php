		<?php 
			if ( is_user_logged_in() ) { 		
			/*Check if user Approve*/

				if( is_user_role( 'customer' ) AND get_field('user_verified', 'user_'.get_current_user_id())!=1){ 
			?>
			

				<div class="col-md-8 waiting-approve-messages">

					<!--<div class="telefire-auth-form">
						<div class="head-form">
							<h2><?php echo get_field('not_verified_title', 643); ?></h2>
						</div>

						<p><?php echo get_field('not_verified_messages', 643); ?></p>
					</div>-->
			


				
			</div>
			<?php
				}

			}
		?>