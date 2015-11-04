<!DOCTYPE html>
<!--[if lt IE 8 ]><html class="no-js ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="no-js ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 8)|!(IE)]><!--><html class="no-js" lang="en"> <!--<![endif]-->
<head>
   <meta charset="utf-8">
	<title><?=$langs['seo_title_invite_friends']?></title>
	<meta name="description" content="<?=$langs['seo_description_invite_friends']?>">
	<meta name="keywords" content="<?=$langs['seo_keywords_invite_friends']?>">

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- Java Script
	================================================== -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="<?=base_url();?>application/views/js/jquery-1.10.2.min.js"><\/script>')</script>
	<script type="text/javascript" src="<?=base_url();?>application/views/js/jquery-migrate-1.2.1.min.js"></script>

	<script src="<?=base_url();?>application/views/js/jquery.flexslider.js"></script>
	<script src="<?=base_url();?>application/views/js/waypoints.js"></script>
	<script src="<?=base_url();?>application/views/js/jquery.fittext.js"></script>
	<script src="<?=base_url();?>application/views/js/magnific-popup.js"></script>
	<script src="<?=base_url();?>application/views/js/invite_friends_init.js"></script>
	<script src="<?=base_url();?>application/views/js/jquery.tooltipster.min.js"></script>

	<link rel="stylesheet" href="<?=base_url();?>application/views/css/default.css">
	<link rel="stylesheet" href="<?=base_url();?>application/views/css/module_layout.css">
	<link rel="stylesheet" href="<?=base_url();?>application/views/css/media-queries.css">
	<link rel="stylesheet" href="<?=base_url();?>application/views/css/magnific-popup.css">
	<link rel="stylesheet" href="<?=base_url();?>application/views/css/tooltipster.css">
	<?php if ($current_lang==2){ ?>
	<link rel="stylesheet" href="<?=base_url();?>application/views/css/russian_bold.css">
	<?php } ?>
	<script src="<?=base_url();?>application/views/js/modernizr.js"></script>

   <!-- recaptcha script
   ================================================== -->
	<?php if ($current_lang==2){ ?>
	<script src='https://www.google.com/recaptcha/api.js?hl=ru'></script>
	<?php } else {?>
	<script src='https://www.google.com/recaptcha/api.js?hl=en'></script>
	<?php }?>
	
</head>

<body>


   <!-- About Section
   ================================================== -->
   <section id="about">

	<nav id="nav-wrap">

		<a class="mobile-btn" href="#nav-wrap" title="<?=$langs['show_navigation']?>"><?=$langs['show_navigation']?></a>
		<a class="mobile-btn" href="#" title="<?=$langs['hide_navigation']?>"><?=$langs['hide_navigation']?></a>

		<ul id="nav" class="nav">
			<li><a class="smoothscroll" href="#about"><?=$langs['top_menu_description']?></a></li>
			<li><a class="smoothscroll" href="#gallery"><?=$langs['top_menu_gallery']?></a></li>
			<li><a href="<?=base_url();?>#portfolio" style="color: #11ABB0;"><?=$langs['top_menu_other_projects']?></a></li>
			<li><a class="smoothscroll" href="#buy" style="color:red !important"><?=$langs['top_menu_byu_now']?></a></li>
			<li class="navigation"><a href="javascript:void(0)"><?=$langs['top_menu_language_'.$current_lang];?></a>
				<ul>
					<li><a href="<?=base_url()?>settings/change_language/1"><span <?php if ($current_lang==1){ ?>class="cust_current"<?php }?>><?=$langs['top_menu_language_1']?></span></a></li>
					<li><a href="<?=base_url()?>settings/change_language/2"><span <?php if ($current_lang==2){ ?>class="cust_current"<?php }?>><?=$langs['top_menu_language_2']?></span></a></li>
				</ul>
			</li>
		</ul> <!-- end #nav -->
	</nav>
		<!--script>
			function load_language(value){
				$.getJSON('<?=base_url()?>settings/change_language/'+value, {}, function(data){
					location.reload();
				});
			}
		</script-->

	<!-- end #nav-wrap -->
      <div class="row">
         <div class="three columns header-col">
            <img src="<?=base_url();?>application/views/images/portfolio/module_invite_friends/image_1.png"/>
         </div>
         <div class="nine columns main-col">
            <h2><?=$langs['projects_invite_friends_module']?></h2>
            <p><?=$langs['projects_invite_friends_module_description_1']?></p>
			<a class="button submit smoothscroll" href="#buy"><?=$langs['top_menu_byu_now']?></a>
         </div> <!-- end .main-col -->
      </div>
   </section> <!-- About Section End-->



   <!-- Portfolio Section--
   ================================================== -->
   <!-- Testimonials Section
   ================================================== -->
	<section id="gallery">
		<div class="text-container">
			<div class="row">
				<div class="two columns header-col"><h2 style="color:#fff"><?=$langs['gallery']?></h2></div>
				<div class="ten columns flex-container">
					<div class="flexslider">
						<ul class="slides">
							<li>
								<img src="<?=base_url();?>application/views/images/portfolio/module_invite_friends/image_4.png">
							</li>
							<li>
								<img src="<?=base_url();?>application/views/images/portfolio/module_invite_friends/image_2.png">
							</li>
							<li>
								<img src="<?=base_url();?>application/views/images/portfolio/module_invite_friends/image_3.png">
							</li>
							<li>
								<img src="<?=base_url();?>application/views/images/portfolio/module_invite_friends/image_1.png">
							</li>
						</ul>
					</div> <!-- div.flexslider ends -->
				</div> <!-- div.flex-container ends -->
			</div> <!-- row ends -->
		</div>  <!-- text-container ends -->
	</section> <!-- Testimonials Section End-->

   <!-- Contact Section
   ================================================== -->
   <section id="buy">

		<div class="row section-head">

			<div class="two header-col">
				<h2><?=$langs['buy_now']?></h2>
			</div>

			<div class="ten">
				<p class="lead" style="margin:0;line-height:1"><?=$langs['form_buy_text_1']?></p>
				<ul class="disc">
					<li><?=$langs['form_buy_text_2']?></li>
					<li><?=$langs['form_buy_text_10']?></li>
					<li><?=$langs['form_buy_text_11']?></li>
					<li><?=$langs['form_buy_text_3']?> <!--i class="fa fa-exclamation-circle selected tooltip" title="<?=$langs['form_buy_text_4']?>"></i--></li>
				</ul>
			</div>

		</div>

         <div class="row">

            <div class="eight columns">

				<!-- form -->
				<form action="<?=base_url();?>buy" method="post" id="paydForm" name="paydForm">
					<input type="hidden" name="product" id="product" value="<?=$module['gid']?>">
					<input type="hidden" name="id_transaction" id="id_transaction" value="">
					<input type="hidden" name="payment_system" id="payment_system" value="">
					<fieldset>
						<div>
							<label for="script"><?=$langs['form_your_script']?> <span class="required">*</span></label>
							<select id="script" name="script">
								<option value=""><?=$langs['form_buy_text_6']?></option>
								<?php foreach ($products as $product){?>
								<option value="<?=$product['gid']?>"><?=$product['name']?></option>
								<?php }?>
							</select>
						</div>

						<div>
							<label for="name"><?=$langs['form_your_name']?> <span class="required">*</span></label>
							<input type="text" value="" size="35" id="name" name="name">
						</div>

						<div>
							<label for="email"><?=$langs['form_email']?> <span class="required">*</span></label>
							<input type="text" value="" size="35" id="email" name="email" placeholder="<?=$langs['form_buy_text_7']?>">
						</div>

						<div>
							<label for="comment"><?=$langs['form_comment']?></label>
							<textarea cols="50" rows="7" id="comment" name="comment" placeholder="<?=$langs['form_buy_text_8']?>"></textarea>
						</div>

						<div class="payment_systems">
							<label for="comment"><?=$langs['form_payment_system']?> <span class="required">*</span></label>
							<i class="fa fa-cc-paypal fa-5x" system="paypal"></i>
							
						</div>

						<div style="margin:15px 0; overflow:hidden;">
							<label></label>
							<div class="g-recaptcha" data-sitekey="6LdmNP8SAAAAAFOowpjp7-lKHKew_NvsVZeyCJLc" style="float:left"></div>
						</div>

						<div>
							<button class="submit"><?=$langs['form_buy']?></button>
							<span id="image-loader">
							<img alt="" src="<?=base_url();?>application/views/images/loader.gif">
							</span>
						</div>

					</fieldset>
				</form> <!-- Form End -->

               <!-- contact-warning -->
               <div id="message-warning"> Error boy</div>
               <!-- contact-success -->
				   <div id="message-success">
						<i class="fa fa-check"></i>thank you!<br>
				   </div>

            </div>


			<aside class="four columns footer-widgets">

				<div class="widget widget_contact">

					<h4><?=$langs['price']?></h4>
					<p style="font-size: 75px; margin: 30px 0px; color: rgb(240, 96, 0);">$<?=$module['price']?></p>

				</div>

				<div class="widget widget_tweets">
					<h4 class="widget-title"><?=$langs['questions']?></h4>
					<p><a style="font-size: 20px;" href="<?=base_url();?>#contact" target="_blank"><i class="fa fa-envelope"></i><?=$langs['contact_me']?></a></p>
				</div>
				
				<?php if (!empty($news)){
					?>
				<div class="widget widget_tweets">
					<h4 class="widget-title"><?=$langs['latest_news']?></h4>
					<ul id="twitter">
					<?php foreach ($news as $item){?>
						<li>
							<span><?=$item['text']?></span>
							<b><a href="#"><?=time_elapsed_string($item['date_created']);?></a></b>
						</li>
					<?php } ?>
					</ul>
				</div>
					<?php } ?>

            </aside>

      </div>

   </section> <!-- Contact Section End-->


   <!-- footer
   ================================================== -->
	<footer>

		<div class="row">

			<div class="twelve columns">

				<ul class="copyright">
					<li>&copy; 2014 <a href="<?=base_url();?>" target="_blank"><?=$langs['pavel_elsukov']?></a></li> 
					<li>Design by <a title="Styleshout" href="http://www.styleshout.com/" target="_blank">Styleshout</a> and <a href="http://lab.yurbasik.org.ua/" target="_blank">lab</a></li>   
				</ul>

			</div>

			<div id="go-top"><a class="smoothscroll" title="Back to Top" href="#about"><i class="icon-up-open"></i></a></div>

		</div>

	</footer> <!-- Footer End-->

	<?php include('tracking.php');?>

</body>
</html>