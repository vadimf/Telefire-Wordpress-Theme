<div class="custom-container companies-search">
	<div class="subscribe" style="background: url(<?php echo get_field('authorised_background_image', 2)['url']; ?>) left center no-repeat rgba(174, 186, 201, 0.9);">

		<div class="pre-search-block">
			<div class="">
				<h2><?php echo get_field('authorised_title', 2); ?></h2>
				<p><?php echo get_field('authorised_text_1', 2); ?> <span class="show_on_tablets"><?php echo get_field('authorised_text_2', 2); ?></span></p>
			</div>
			<div class="subscribe-inner">
				<p class="hide_on_tablets"><?php echo get_field('authorised_text_2', 2); ?></p>
				<!-- <div class="search-company-form">
					<input type="text" placeholder="הקלד שם המתקין" name="searc-company"> 
					<input type="button" id="search_company" value="חפש">
				</div> -->
				<form id="search-companies">
					<input type="text" placeholder="הקלד שם המתקין" name="searc-company" id="searc-company"> 
					<input type="submit" id="search_company" value="חפש">
				</form>
				<div class="mobile-on-phone">
					<p><small><?php echo get_field('authorised_text_3', 2); ?></small>
				</div>
			</div>
		</div>
		
		<script>

		jQuery(document).ready(function($){

			var ajaxurl = "/wp-admin/admin-ajax.php";

			function get_companies_list() {
				var data = {
					action: 'get_companies',
					title: $('[name="searc-company"]').val()
				};
				$.post(ajaxurl, data, function(d){
					if (d.status == 'success'){
						var str = '';
						for(i in d.data){
							str += '<h4><a class="open_info_company" data-id='+d.data[i].ID+'">'+d.data[i].post_title+' <img src="<?php echo get_template_directory_uri() ; ?>/assets/images/neadr-link.png"></a></h4>';
						}
						$('.company-lists').html(str);
						$('.pre-search-block').css('display', 'none');
						$('.search-block').css('display', 'block');
						$('.company-lists').css('display', 'block');
						$('.company-detail').css('display', 'none');
					}

					if (d.status == 'not-found')
						alert('<?php echo get_field('messages_if_not_found', 'option'); ?>');

					if (d.status == 'fail')
						alert('<?php echo get_field('messages_if_empty', 'option'); ?>');

				}, 'json');
			}

			// $('#search_company').click(function(){
			// 	get_companies_list();
			// });
			$('#search-companies').on('submit', function(){

				$('.page-id-1967 .main-content').css('display', 'none');
				//

				get_companies_list();
				return false;
			});
			$('.company-lists').on('click', '.open_info_company', function(){
                var id = $(this).data('id');
			    /*
				var data = {
					action: 'get_company_by_id',
					id: $(this).data('id')
				};

				$('.company-lists').css('display', 'none');

				$.post(ajaxurl, data, function(d){
					if (d.status == 'success'){
						$('.company-detail .info.title').html(d.data.title);
						$('.company-detail .info.type').html(d.data.type);
						$('.company-detail .info.addres').html(d.data.addres);
						$('.company-detail .info.products').html(d.data.products);
						$('.company-detail .info.date').html(d.data.date);
					}else
						alert(d.message);
				}, 'json');

				$('.company-detail').css('display', 'block');
				$('.return-to-list').css('display', 'block');
                */
			    //alert('Open in new tabs');
			    //console.log('open new tab');
                //window.open("https://www.youraddress.com","_self")
                window.open("/?p="+id, "_self");
                return false;
			});
			$('.return-to-list').on('click', function(e) {
				e.preventDefault();
				$('.search-block').css('display', 'none');
				$('.return-to-list').css('display', 'none');
				$('.pre-search-block').css('display', 'block');
			});
		});
		</script>

		<div class="search-block" style="display: none">
			<h3>תוצאות חיפוש  </h3>
			<a href="#" class="btn-telefire return-to-list" style="display: none">
				<span>חזרה לחיפוש</span>
			</a>
			<div class="search-result-scroll">


				<!-- Company Lists -->
				<div class="company-lists">
				  
				</div>

			
				<!-- Company information by ID click -->
				<div class="company-detail" style="display: none">
					<h4>
						<div class="legend">שם חברה  </div>
						<div class="info title"></div>
						<div class="clearfix"></div>
					</h4>
					<h4>
						<div class="legend">סוג האישור  </div>
						<div class="info type"></div>
						<div class="clearfix"></div>
					</h4>
					<h4>
						<div class="legend">כתובת בית העסק  </div>
						<div class="info addres"></div>
						<div class="clearfix"></div>
					</h4>
					<h4>
						<div class="legend">דגמי המערכות המאושרות  </div>
						<div class="info products"></div>
						<div class="clearfix"></div>
					</h4>
					<h4 class="last">
						<div class="legend">תוקף התעודה  </div>
						<div class="info date"></div>
						<div class="clearfix"></div>
					</h4>



				</div>

			</div>

		</div>
	</div>
</div>

<script type="text/javascript">
	
		//search_company
		jQuery("#search_company").click(function() {	
			var search_company = document.getElementById('searc-company').value;
			console.log('Click btn search company with value:'+search_company);

			dataLayer.push({'Category':'Authorized installer','Action':'search','Label': ''+search_company+'' ,'event':'auto_event'});
			console.log(dataLayer);

		}); 
	
</script>