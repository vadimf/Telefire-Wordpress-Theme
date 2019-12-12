<?php
global $fields;
$sidebar_group = get_field('sidebar', 'option');	
?>	

<aside class="col-lg-3 col-md-12 sidebar">
	<div class="sidebar_top" style="background-image:url(<?php echo $sidebar_group['bg_sidebar']['url']; ?>">
		 <img src="<?php echo $sidebar_group['icon_sidebar']['url']; ?>" alt="Icon" />
	</div>
	<ul>
		<?php wp_get_archives(); ?>
	</ul>
</aside><!-- .sidebar -->