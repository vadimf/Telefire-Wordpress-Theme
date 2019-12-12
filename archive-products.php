<?php
/*
Template name: Products Lobby
*/
get_header();

$active_cat = (isset($_GET['cat']) && !empty($_GET['cat'])) ? $_GET['cat'] : false;
?>

<!-- <script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script> -->

<div class="products-lobby-content">
<div class="our-products">
	<div class="custom-container">
		<div class="our-products-inner">
		<h2><?php echo get_field('products_title'); ?></h2>
		<div class="row">
			<div class="categories-list">



				<?php 

				//print_r(get_field('products_category_sort', 426));
				$category_active_by_default =  get_field('products_category_active',426);
				//echo "/****/";
				

				
				$catsArray = get_field('products_category_sort', 426);		
				$taxonomy = 'products_category';
				$terms = get_terms(
					array(
						'taxonomy'      => array( 'products_category' ), 
						'include' => $catsArray,
						'orderby'  => 'include',
						 'hide_empty' => true
						// 'orderby'       => 'id', 
						// 'order'         => 'ASC',
					) 
				); 
				if ( $terms && !is_wp_error( $terms ) ) :
					usort($terms, 'sac_sort_terms_by_description');
				?>
				<?php 
					$key = 1;
					foreach ( $terms as $term ) {

					//$term = get_queried_object();
					$category_id = $term->term_id;
				 ?>
				 <style>
				  	a .cat-icon<?php echo $category_id; ?> {
				        width: 140px;
				        height: 150px;
				        background-image: url("<?php echo get_field('category_icon', 'products_category_'.$category_id); ?>");
				        background-repeat: no-repeat;
				        display: inline-block;
					    -webkit-transition: all 0.5s ease 0s;
    					transition: all 0.5s ease 0s;
				    }
				    .active a .cat-icon<?php echo $category_id; ?>, a:hover .cat-icon<?php echo $category_id; ?> {
				        background-image: url("<?php echo get_field('category_icon_active', 'products_category_'.$category_id); ?>");
				        background-repeat: no-repeat;
				        background-size: contain;
						background-position: center;
				    }
				    @media only screen and (max-width: 520px) {
				    	a .cat-icon<?php echo $category_id; ?> {
					        width: 100%;
							height: 100px;
							background-size: contain;
							background-position: center;
					    }
					    a:hover .cat-icon<?php echo $category_id; ?> {
					    	background-size: contain;
							background-position: center;
					    }
				    }
				 </style>
				 
					    <div class="item id<?php echo $category_id; ?> <?php //if($category_active_by_default==$category_id){ echo " active"; }?>">

							<a data-filter="category-<?php echo $category_id; ?>" data-name="<?php echo $term->name; ?>">
								<div class="cat-icon<?php echo $category_id; ?>">
									<img class="shop-cat-icon" src="<?php echo get_field('category_icon', 'products_category_'.$category_id); ?>" alt="Icon">
									<img class="shop-cat-icon hover" src="<?php echo get_field('category_icon_active', 'products_category_'.$category_id); ?>" alt="Icon">
								</div>
								<h3 class="title">
									<?php echo $term->name; ?>
								</h3>
							</a>
						</div>
						
				<?php 
					$key++;
					} 
				?>
				<?php endif;?>
				
				</div>
			</div>
			</div>
		</div>
	</div>

	


<div class="custom-container products-container">

<?php

$terms_secondary = get_terms(
	array(
		'taxonomy'      => array( 'products_category_2' ), 
		'orderby'       => 'name', 
		// 'order'         => 'ASC',
	) 
); 
if ( $terms_secondary && !is_wp_error( $terms_secondary ) ) :

	foreach ( $terms_secondary as $term ) : ?>

	<div class="products-cat2-container">
	
		<div class="content-title">
			<?php
			// $taxonomy_name = 'products_category';
			// $chapname = get_term($category_active_by_default, $taxonomy);
			?>

			<h2 class="current-category-title">	
				<?php echo $term->name; ?>
			</h2>
		</div>

		<?php
		$args = array(			
			'post_type' => 'products',
			// 'orderby' => 'date', 
			//'order' => 'DESC',
			'orderby' => 'menu_order', 
			'order' => 'ASC',
			'tax_query' => array(
				array(
					'taxonomy' => 'products_category_2',
					'field'    => 'id',
					'terms'    => $term->term_id
				)
			)	
		);
		//print_r( $args);
		$loop = new WP_Query( $args );
		if ( $loop->have_posts() ) : ?>
		<div class="row">
			<!-- <div class="grid"> -->
				<?php while ( $loop->have_posts() ) { $loop->the_post();

					$categories = get_the_terms( $post->ID, 'products_category' );
					$filter_str = '';
					if (count($categories)) {
						foreach($categories as $cat) {
							$filter_str .= 'category-' . $cat->term_id . ' ';
						}
					} else $filter_str = 'empty';

				 ?>
				<div class="col-lg-4 col-md-6 products_lobby_item element-item metal <?php echo $filter_str; ?>" data-label="<?php echo $filter_str; ?>">
					<div class="video_imgs">
						<a href="<?php echo the_permalink(); ?>">
							<?php the_post_thumbnail('products-lobby'); ?>									
						</a>
					</div>
					<div class="course_item_text">

						<a href="<?php the_permalink(); ?>"><h2><?php the_title(); ?></h2></a>
					</div>	
				</div>
				<?php } ?>

			<!-- </div> -->

		</div>

		<?php wp_reset_postdata();	
		endif;

		?>
	</div>

	<?php endforeach;
endif;

?>


</div>

</div>





<script type="text/javascript">
// external js: isotope.pkgd.js

// init Isotope
// var $grid = jQuery('.grid').isotope({
//   itemSelector: '.element-item',
//   layoutMode: 'fitRows',

//   /*Category active by default */
//   filter: '',//'.category-<?php echo $category_active_by_default; ?>',
  
//   // RTL rooles
//   isOriginLeft: false,

// });
// // filter functions
// var filterFns = {
//   // show if number is greater than 50
//   numberGreaterThan50: function() {
//     var number = jQuery(this).find('.number').text();
//     return parseInt( number, 10 ) > 50;
//   },
//   // show if name ends with -ium
//   ium: function() {
//     var name = jQuery(this).find('.name').text();
//     return name.match( /ium$/ );
//   }
// };
// // bind filter button click
// jQuery('.categories-list').on( 'click', 'a', function() {
//   var filterValue = jQuery( this ).attr('data-filter');
//   var filterName = jQuery( this ).attr('data-name');

//   //alert(filterName);

//   //jQuery(".current-category-title").text(filterName);
//   // use filterFn if matches value
//   filterValue = filterFns[ filterValue ] || filterValue;
//   $grid.isotope({ filter: filterValue });
// });
// change is-checked class on buttons
// jQuery('.categories-list').each( function( i, buttonGroup ) {
//   var $buttonGroup = jQuery( buttonGroup );
//   $buttonGroup.on( 'click', '.item', function() {
//     $buttonGroup.find('.active').removeClass('active');
//     jQuery( this ).addClass('active');
//   });
// });

var filter_common = function($this, $filters, $boxes) {

    $filters.closest('.item').removeClass('active');
    $this.closest('.item').addClass('active');

	var $filterColor = $this.attr('data-filter');

    if ($filterColor == 'all') {
      	$boxes.removeClass('is-animated').fadeOut().promise().done(function() {
        	$boxes.addClass('is-animated').fadeIn();
        });
    } else {
    	jQuery('.products-cat2-container .content-title').fadeOut();
      	$boxes.removeClass('is-animated').fadeOut().promise().done(function() {
			$boxes.filter("." + $filterColor).addClass('is-animated').fadeIn();
			
			var ttt = jQuery('.products-cat2-container');
			jQuery.each(ttt, function(k,v) {
				if (jQuery(v).find('.is-animated').length == 0) {
					jQuery(v).find('.content-title').fadeOut();
				} else jQuery(v).find('.content-title').fadeIn();
			});
        });
    }
};

var $filters = jQuery('.categories-list [data-filter]'),
	$boxes = jQuery('.products-cat2-container [data-label]');

$filters.on('click', function(e) {
	e.preventDefault();
	filter_common(jQuery(this), $filters, $boxes);
});


var id = '<?php if ($active_cat) echo $active_cat; else echo 0; ?>'
jQuery(".categories-list").find("[data-filter='" + id + "']").click(); 


</script>

<?php 

get_footer();

?>