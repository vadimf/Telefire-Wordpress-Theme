;(function($) {

	$(document).ready(function() {



		var _this = {

			

			// Init all data

			__construct: function() {



				// vars

				_this.header = $('#header');

				_this.openMenuButton = $('.pie');

				_this.closeMenuButton = $('#close_menu');

				_this.lightboxMenuContainer = $('.lightbox_menu');

				_this.openForm = $('.apply-form');

				_this.lightboxFormContainer = $('.lightbox_menu_apply');

				_this.closeFormButton = $('#close_form');



				_this.webinarRegionSelectTop = $('.buttons-on-mobile button');

				_this.webinarRegionSelect = $('.buttons-on-mobile');



				_this.firstFloorIndicators = $('#carousel1Floor .carousel-indicators li');



				_this.smallImageItem = $('.small-image-item');

				_this.bigImages = $('.innovation-big-images');



				_this.socialShare = $('.social_button');

				_this.sticky_nav_bar = $('.sticky_left_sidebar');



			},



			// Call functions

			init: function() {

				_this.__construct();

				AOS.init({

				    disable: function() {

				      return /bot|googlebot|crawler|spider|robot|crawling/i.test(navigator.userAgent);

				    }

				});

				$('[data-fancybox]').fancybox({

				    toolbar  : false,

				    smallBtn : true,

				 });

				_this.headroom();

				_this.menu();

				_this.social();

				_this.faq();

				_this.slowScroll();

				_this.general();

				_this.leftSidebarScroll();

				_this.cf7();

				_this.styleInputNumber();

			},



			headroom: function() {

				var myElement = document.querySelector("header");

				var headroom  = new Headroom(myElement);



				headroom.init();



				// var myElement1 = document.querySelector("#mobile-header-headroom");

				// var headroom1  = new Headroom(myElement1);



				// headroom1.init();

				

			},



			menu: function() {



				_this.openMenuButton.on('click', function(e) {

					e.preventDefault();

					$(this).toggleClass('menu-open');
					$(this).closest('#header').toggleClass('menu-animate');
					if ($(this).closest('#header').hasClass('menu-animate')) $(this).closest('#header').find('.mobile-menu').animate({'right':'0px'},500);
					else $(this).closest('#header').find('.mobile-menu').animate({'right':'-100%'},500);
				});



				_this.closeMenuButton.on('click', function(e) {

					e.preventDefault();

					_this.lightboxMenuContainer.fadeOut();//removeClass('menu-visible');

				});



				_this.closeFormButton.on('click', function(e) {

					e.preventDefault();

					_this.lightboxFormContainer.fadeOut();

				});



				_this.openForm.on('click', function(e) {

					e.preventDefault();

					_this.lightboxMenuContainer.fadeOut();

					_this.lightboxFormContainer.fadeIn();

				});



			},



			leftSidebarScroll: function() {

				if (_this.sticky_nav_bar.length) {

					var sticky_nav_bar_height = _this.sticky_nav_bar.height();

					var el_height = _this.sticky_nav_bar.offset().top;

					var admin_bar = 0;



					if ($('body').hasClass('admin-bar')) {

						admin_bar = 32;

					}



					$(window).on('scroll', function() {

						if ($(window).width() > 992) {

							var height = $(this).scrollTop(),

								header_height = 100, //$('#header').height(),

								result = el_height - header_height - admin_bar,

								top = header_height + admin_bar,

								next_item = sticky_nav_bar_height + 20;



							if (height >= result) 

								_this.sticky_nav_bar.css({'position':'fixed', 'top': top}).addClass('slideDown').next().css({'padding-top': next_item + 'px'});

							else 

								_this.sticky_nav_bar.css({'position': 'inherit', 'top': 0}).removeClass('slideDown').next().css({'padding-top': '20px'});

						}



					});

				}

			},



			social: function() {

				_this.socialShare.on('click', function(a) {

					if (a.preventDefault(), "mobile" == jQuery(this).data("facebook")) FB.ui({

					    method: "share",

					    mobile_iframe: !0,

					    href: jQuery(this).data("href")

					}, function(a) {});

					else if ("email" == jQuery(this).data("site") || "print" == jQuery(this).data("site") || "pinterest" == jQuery(this).data("site")) window.location.href = jQuery(this).attr("href");

					else {

					    var b = 575,

					      	c = 520,

					      	d = (jQuery(window).width() - b) / 2,

					      	e = (jQuery(window).height() - c) / 2,

					      	f = "status=1,width=" + b + ",height=" + c + ",top=" + e + ",left=" + d;

					    window.open(jQuery(this).attr("href"), "share", f)

					}

				});

			},



			faq: function() {

				$('.question-item-title').on('click', function() {

					if ($('.question-item').length) {

						$.each($('.question-item'), function(k,v) {

							if ($(v).hasClass('current')) $(v).removeClass('current');

						});

					}

					$(this).closest('.question-item').toggleClass('open-list2').addClass('current').find('.question-answer').slideToggle('slow');

					if ($(this).closest('.question-item').hasClass('open-list2')) {

						$(this).closest('.question-item').find('.question-arrow i').removeClass('fa-angle-down').addClass('fa-angle-up');

					} else $(this).closest('.question-item').find('.question-arrow i').removeClass('fa-angle-up').addClass('fa-angle-down');



					if ($('.question-item.open-list2').length) {

						$.each($('.question-item.open-list2'), function(k,v) {

							if (!$(v).hasClass('current')) {

								$(v).toggleClass('open-list2').find('.question-answer').slideToggle('slow');

								$(this).find('.question-arrow i').removeClass('fa-angle-up').addClass('fa-angle-down');

							}

						});

					}

				});

				$('.sidebar_top .circle').on('click', function() {
					$(this).toggleClass('open');
					
					if ($(this).hasClass('open')) $(this).find('i').attr('class', 'fa fa-angle-up');
					else $(this).find('i').attr('class', 'fa fa-angle-down');

					$(this).closest('.sidebar-mobile').find('ul').slideToggle('slow');
				});


				$('.page-template-template-faq .slider-buttons a').on('click', function(e) {

					var href = $(this).attr('href');

					if (href.charAt(0) === '#') {

						e.preventDefault();

						href = href.substr(1);



						$.each($('.page-template-template-faq .slider-buttons a'), function(k,v) {$(v).removeClass('filter-selected')});

						$(this).addClass('filter-selected');



						$('.questions-title').removeClass('is-animated').fadeOut().promise().done(function() {

				        	$('.questions-title').text($('.page-template-template-faq .slider-buttons a.filter-selected').text()).addClass('is-animated').fadeIn();

				        });



				        $(this).closest('.slider-buttons').find('.buttons-on-mobile').removeClass('open');



						var items = $('.question-item');



						items.removeClass('question-animated').fadeOut().promise().done(function() {

							items.filter("." + href).addClass('question-animated').fadeIn();

						});

					}

				});

			},



			slowScroll: function() {

				var hash = window.location.hash;
				if (hash != '' && hash != '#') {
					var id = hash.slice(1);
					var target = jQuery('#' + id);
					if (target.length) {
						jQuery('html, body').animate({
				        	scrollTop: target.offset().top - 105
				    	}, 1000);
					}
				}

				$('a[href*="#"]')

			  	.not('[href="#"]')

			  	.not('[href="#0"]')

			  	.click(function(event) {

			    	if (

			      		location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') 

			      			&& 

			      		location.hostname == this.hostname

			    	) {

				      	var target = $(this.hash);

				      	target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');

				      	if (target.length) {

				      		if (!$(this).hasClass('slider-link')) {

					        	event.preventDefault();

					        	$('html, body').animate({

					          		scrollTop: target.offset().top - 105

					        	}, 1000, function() {

					          		

					        	});

					        }

				      	}

				    }

			  	});


			  	$('.left-sidebar ul li span').on('click', function() {

			  		if ($(this).closest('.left-sidebar').hasClass('open')) {

						$(this).closest('.left-sidebar').animate({

					    	height: '51px'

					    }, 700, function() {

					    	// Do anything after scroll

					    }).removeClass('open');

			  		} else {

			  			$(this).closest('.left-sidebar').animate({

					    	height: '100%'

					    }, 700, function() {

					    	// Do anything after scroll

					    }).addClass('open');

			  		}

			  	});

			},



			general: function() {

				_this.webinarRegionSelectTop.on('click', function() {

					$(this).parent().toggleClass('open');

				});

				$('body').click(function (e) {

					if($(e.target).closest('.buttons-on-mobile').length == 0) {

						if (_this.webinarRegionSelect.hasClass('open')) 

							_this.webinarRegionSelect.removeClass('open');

					}

				});



				if ($(window).width() > 992) {

					$('#carousel1Floor.carousel .carousel-item').each(function(){

					  var next = $(this).next();

					  if (!next.length) {

					    next = $(this).siblings(':first');

					  }

					  next.children(':first-child').clone().appendTo($(this));

					});

				}



				_this.firstFloorIndicators.on('click', function() {

					var id = $(this).data('slide-to');

					if ($(this).closest('.hp-first-floor').find('.slide-content.active').data('slide-to') != id) {

						$(this).closest('.hp-first-floor').find('.slide-content.active').fadeOut().promise().done(function() {

							$('.hp-first-floor .slide-content.active').removeClass('active');

							$('.hp-first-floor').find('.slide-content[data-slide-to="'+ id +'"]').fadeIn().addClass('active');

						});

					}

				});

				$('.carousel-sync').carousel('cycle');
				$('.carousel-sync').on('click', 'li[data-slide-to]', function (ev) {
					ev.preventDefault();
				    $('.carousel-sync').carousel($(this).data('slide-to'));
				});

				setInterval(function(){ 

				    if (jQuery('#carouselCampus').find('.active').next().length ) {

				    	jQuery('#carouselCampus').find('.active').fadeOut('slow').promise().done(function() {

				    		jQuery('#carouselCampus').find('.active').removeClass('active').next().fadeIn('slow').addClass('active');

				    	});

				    } else {

				    	jQuery('#carouselCampus').find('.active').fadeOut('slow').promise().done(function() {

				    		jQuery('#carouselCampus').find('.active').removeClass('active');

				    		var first = jQuery('#carouselCampus').find('.item2')[0];

				    		jQuery(first).fadeIn('slow').addClass('active');

				    	});

				    }

				}, 6000);

				

				$(window).scroll(function(){
                   	if ($(this).scrollTop() > 600 ) {
				        $("#back_to_top").fadeIn(200);
				    } else {
				        $("#back_to_top").fadeOut(200);
				    }
				});

				

				setInterval(function(){ 

				

					for(x=0;x<3;x++)

					{

						if (jQuery('#carouselAlumni').find('.cube-item.active').next().not(".active").not(".waiting").length) // go to first

						{

							jQuery('#carouselAlumni').find('.cube-item.active').next().not(".active").not(".waiting").addClass("waiting");

						}

						else

						{

							jQuery('#carouselAlumni').find('.cube-item').first().addClass("waiting");

						}

					}

					

					jQuery('#carouselAlumni').find('.active').fadeOut('slow').promise().done(function() { jQuery(this).removeClass("active"); });

					jQuery('#carouselAlumni').find('.waiting').removeClass("waiting").fadeIn('slow').promise().done(function() { jQuery(this).addClass('active').find("[data-aos]").addClass("aos-animate"); } );

					

				}, 6000);

				
				var resp_iframes = jQuery('body').find('iframe');

				if (resp_iframes.length)
				jQuery.each(resp_iframes, function(k,v) {
					jQuery(v).parent().addClass('resp-iframe');
				});
				

			},

			styleInputNumber: function() {
				jQuery('<div class="quantity-nav"><div class="quantity-text"> יח׳</div><div class="quantity-button quantity-up">+</div><div class="quantity-button quantity-down">-</div></div>').insertAfter('.single-product-qt .quantity input');
			    jQuery('.single-product-qt .quantity').each(function() {
			      var spinner = jQuery(this),
			        input = spinner.find('input[type="number"]'),
			        btnUp = spinner.find('.quantity-up'),
			        btnDown = spinner.find('.quantity-down'),
			        min = input.attr('min'),
			        max = (input.attr('max') != '') ? input.attr('max') : 1000,
			        ajax_add_to_cart = spinner.closest('.single-product-qt').find('.ajax_add_to_cart');

			      btnUp.click(function() {
			        var oldValue = parseFloat(input.val());
			        if (oldValue >= max) {
			          var newVal = oldValue;
			        } else {
			          var newVal = oldValue + 1;
			        }
			        ajax_add_to_cart.attr('data-quantity', newVal);
			        spinner.find("input").val(newVal);
			        spinner.find("input").trigger("change");
			      });

			      btnDown.click(function() {
			        var oldValue = parseFloat(input.val());
			        if (oldValue <= min) {
			          var newVal = oldValue;
			        } else {
			          var newVal = oldValue - 1;
			        }
			        ajax_add_to_cart.attr('data-quantity', newVal);
			        spinner.find("input").val(newVal);
			        spinner.find("input").trigger("change");
			      });

			      input.focusin(function(){
			      	if($(this).val().trim() != ''){
			      		$(this).attr('data-val', $(this).val()).val('');
			      	}
			      });

			      input.focusout(function(){
			      	if($(this).val().trim() == ''){
			      		$(this).val($(this).attr('data-val'));
			      	}
			      	ajax_add_to_cart.attr('data-quantity', $(this).val());
			      });

			    });
			},


			cf7: function() {

				function activateFormElement( element ) {

				element.addClass('active');

				var input = element.find('input, select, textarea');

					if( input.length && !input.is(":focus") ){

						input.focus();

					}

				} 

				$('.cf-apply form .col-12 > span').click(function(){

					activateFormElement($(this));

				});

				$('.cf-apply form .col-12 > span').focusin(function(){

					//console.log('focus');

					activateFormElement($(this));

				});

				$('.cf-apply form .col-12 > span').focusout(function(){

					var input = $(this).find('input');

					if( input.length && input.val() === '' ){

						$(this).removeClass('active');

					}    

						

					var select = $(this).find('select');

					if( select.length && select.val() === '' ){

					  $(this).removeClass('active');

					}    

					

					var textarea = $(this).find('textarea');

					if( textarea.length && textarea.val() === '' ){

					  $(this).removeClass('active');

					}    

					

				});

				$('.cf-apply .checkbox input[type=checkbox]').on('click', function() {

					$(this).closest('.checkbox').find('.checkbox_style').toggleClass('checked');

				});

			},



		}



		_this.init();



	});

	
})(jQuery);

/*FancyBox*/

  
// jQuery(document).ready(function() {

//   	jQuery(".video").click(function() {
//     	jQuery.fancybox({
// 	    	'type'		: "iframe",
// 	      	'padding'   : 0,
// 	      	// 'autoScale'   : false,
// 	      	// 'transitionIn'  : 'none',
// 	      	// 'transitionOut' : 'none',
// 	      	// 'title'     : this.title,
// 	      	'width'     : 640,
// 	      	'height'    : 385,
// 	      	'href'      : this.href.replace(new RegExp("watch\\?v=", "i"), 'v/'),
// 	      	// 'type'      : 'swf',
// 	      	// 'swf'     : {
// 		      // 	'wmode'       : 'transparent',
// 		      // 	'allowfullscreen' : 'true'
// 	      	// }
//     	});

//     	return false;
//   	});

// });

jQuery(document).ready(function () {
    // jQuery(".video").fancybox({
    //     type: "iframe", //<--added
    //     padding: 0,
    //     maxWidth: 800,
    //     maxHeight: 600,
    //     fitToView: false,
    //     width: '70%',
    //     height: '70%',
    //     autoSize: false,
    //     closeClick: false,
    //     openEffect: 'none',
    //     closeEffect: 'none'
    // });
    jQuery('[data-fancybox]').fancybox({
	    // youtube : {
	    //   	showinfo : 0,
	    //   	autoplay : 1,
	    //   	rel : 0,
	    // },
	    // vimeo : {
	    //   color : 'f00'
	    // },
	    // type: 'iframe',
	    // padding: 0,
	    toolbar  : false,
	    smallBtn : true,
	});
})



jQuery().ready(function(){
  jQuery('.slick-carousel').slick({
    arrows: true,
    centerPadding: "0px",
    dots: true,
    slidesToShow: 1,
    infinite: false
  });
});


/*
	Load more 
*/   
jQuery().ready(function(){
    // jQuery(".course_item").slice(0, 9).show();
    jQuery(".loadMore").on('click', function (e) {
        e.preventDefault();
        jQuery(this).closest(".type_block").find(".course_item:hidden").slideDown();
        if (jQuery(".course_item:hidden").length == 0) {
            jQuery(this).fadeOut('slow');
        }
        jQuery(this).hide();
        jQuery('html,body').animate({
            scrollTop: jQuery(this).offset().top
        }, 1500);
    });

});

//Open reg form
jQuery('.open-reg-form').click(function(){
	jQuery(this).hide();
	jQuery(this).next().slideDown(500);
});

//Show password
jQuery('.toggle-password').click(function(){
  jQuery(this).toggleClass("fa-eye fa-eye-slash");
  var input = jQuery(this).parent().find('.input-text');
  if(input.attr("type") === "password") {
    input.attr("type", "text");
  }else{
    input.attr("type", "password");
  }
});

//Update the number of items in the cart
jQuery(document.body).on("added_to_cart", function() {
	jQuery.ajax({
      type: "POST",
      url: '/wp-admin/admin-ajax.php',
      data:{
        action: 'ajax_get_cart_count',
      }
    }).done(function(data){
    	jQuery('.cart_section .cart_items').text(data);
    	jQuery('.fixed-mobile-cart span').text(data);
    });
});

//Auto Update Cart
jQuery('div.woocommerce').on('change', 'input.qty', function(){ 
    jQuery("[name='update_cart']").trigger("click"); 
}); 

jQuery('div.woocommerce').on('focusin', 'input.qty', function(){
	if(jQuery(this).val().trim() != ''){
		jQuery(this).attr('data-val', jQuery(this).val()).val('');
	}
});

jQuery('div.woocommerce').on('focusout', 'input.qty', function(){
	if(jQuery(this).val().trim() == ''){
		jQuery(this).val(jQuery(this).attr('data-val'));
	}
});

//Fixing a search when scrolling to it
jQuery(function(){
	var	fixed = jQuery('.search-form-products');
	if(jQuery.isPlainObject(fixed.offset())){
		var topPos = fixed.offset().top;
			
		jQuery(window).on('scroll resize load', function(){
			console.log(jQuery(window).innerWidth());
			if(jQuery(this).width() <= 583){ 
				fixed.removeClass('fixed');
				return;
			}

			var top = jQuery(document).scrollTop(),
				header_h = jQuery('#header').outerHeight(),
				wpadminbar_h = 0;

			if(jQuery('#wpadminbar').is('div')){
				wpadminbar_h = jQuery('#wpadminbar').outerHeight();
			}

			if ((top + header_h + wpadminbar_h) > topPos) fixed.addClass('fixed');
			else fixed.removeClass('fixed');
		});
	}
});

jQuery( document ).on('click', 'button#place_order', function(){
	jQuery('.checkout__message').show();
});
jQuery( document.body ).on('checkout_error', function(){
	jQuery('.checkout__message').hide();
});
