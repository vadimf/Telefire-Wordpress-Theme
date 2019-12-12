<div class="functions-product">
<?php
	$fields = get_fields();
	$cta_banner = get_field('cta_banner', 'option'); //to get group field

	// for links
 	$link_main = $cta_banner['link_main'];	 // to get repeater field
 	$links = ($fields['link_banner']) ? $fields['link_banner'] : $link_main;

 	// for main title 
	$title_main = $cta_banner['title_cta_main'];	//to get main title	
	$cta_title = ($fields['title_cta']) ? $fields['title_cta'] : $title_main;

 	// for background image
 	$bg_main = $cta_banner['cta_bg_image_main']; //to get main background image
	$cta_bg = ($fields['cta_bg_image']) ? $fields['cta_bg_image'] : $bg_main;

	// for background color
	$bg_color_main = $cta_banner['cta_bg_color_main']; //to get main background color
	$cta_color = ($fields['cta_bg_color']) ? $fields['cta_bg_color'] : $bg_color_main;


 ?>



<div class="custom-container cta_banner_wrap" style="background-color:<?php echo $cta_color; ?>; background-image:url(<?php echo $cta_bg['url']; ?>">
	<div class="">
		<div class="functions-title">
		<?php echo get_field('functions_title'); ?>			
		</div>
	</div>
	<div class="row banner_items">


<?php if(get_field('functions_list')): ?>
	<div class="block functions-item">
		<ul>
			<?php while(has_sub_field('functions_list')): ?>
				<li>

					<img src="<?php the_sub_field('icon'); ?>"><br />
					<?php the_sub_field('title'); ?>
				 

			</li>
			<?php endwhile; ?>
	 	</ul>
	</div> <!---.block -->
<?php endif; ?>



	</div><!-- .banner_items -->
</div><!-- .cta_banner_wrap --> 
</div>