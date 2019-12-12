<?php
/**
 * Page not found template - 404
 */

get_header(); ?>

<div class="error-banner" style="background-image: url(<?php echo site_url(); ?>/wp-content/uploads/2018/05/slide1-1.jpg)">
	<div class="custom-container">
		<div class="banner-container">
			<h1>הדף לא נמצא</h1>
		</div>
	</div>
</div>
<div class="error-content">
	<div class="custom-container">
		<h4>קח אותי בחזרה <a href="<?php echo home_url(); ?>"><?php echo home_url(); ?></a></h4>
	</div>
</div>

<?php get_footer(); ?>