<?php

global $fields;

$sidebar_group = get_field('sidebar', 'option');	

?>	



<aside class="col-lg-3">
	<div class="sidebar">

	<div class="sidebar_top" style="background-image:url(<?php echo $sidebar_group['bg_sidebar']['url']; ?>">

		 <img src="<?php echo $sidebar_group['icon_sidebar']['url']; ?>" alt="Icon" />

	</div>




	<ul class="ads-post">

			<li class="item">
								
								<a href="<?php echo get_field('sidebar_link'); ?>"><h4><?php echo get_field('sidebar_title'); ?></h4></a>

								<a href="<?php echo get_field('sidebar_link'); ?>">
									<div class="img-article" style="background: url('<?php echo get_field('sidebar_image'); ?>') no-repeat; background-size: cover; height: 185px">
									
									</div>
								</a>
								<div class="description">
								
								
								<p><?php echo get_field('sidebar_desc'); ?></p>
								<a href="<?php echo get_field('sidebar_link'); ?>" class="read-more"><?php echo get_field('sidebar_text_link'); ?></a>
								</div>
							</li>
		

	</ul>

	</div>

</aside><!-- .sidebar -->