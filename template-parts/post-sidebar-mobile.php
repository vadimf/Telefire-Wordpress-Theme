<?php
global $fields;
$sidebar_group = get_field('sidebar', 'option');	
?>	

<aside class="col-lg-3 col-md-12 sidebar-mobile sidebar">
	<div class="sidebar_top" style="background-image:url(<?php echo $sidebar_group['bg_sidebar']['url']; ?>">
		<span class="circle">
			<i class="fa fa-angle-down" aria-hidden="true"></i>	
		</span>
		<span><?php echo $sidebar_group['mobile_text']; ?></span>
	</div>
	<ul>
		<?php wp_get_archives(); ?>
	</ul>
</aside><!-- .sidebar -->