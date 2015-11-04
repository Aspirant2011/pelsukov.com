<!DOCTYPE html>
<!--[if lt IE 8 ]><html class="no-js ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="no-js ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 8)|!(IE)]><!--><html class="no-js" lang="en"> <!--<![endif]-->
<head>
   <meta charset="utf-8">
	<title><?=$langs['seo_title_welcome']?></title>
	<meta name="description" content="<?=$langs['seo_description_welcome']?>">
	<meta name="keywords" content="<?=$langs['seo_keywords_welcome']?>">

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name='yandex-verification' content='750d1c8feb34e4b3' />

   <link rel="stylesheet" href="<?=base_url();?>application/views/css/default.css">
	<link rel="stylesheet" href="<?=base_url();?>application/views/css/layout.css">
   <link rel="stylesheet" href="<?=base_url();?>application/views/css/media-queries.css">
   <link rel="stylesheet" href="<?=base_url();?>application/views/css/magnific-popup.css">
	<?php if ($current_lang==2){ ?>
	<link rel="stylesheet" href="<?=base_url();?>application/views/css/russian_bold.css">
	<?php } ?>

	<script src="<?=base_url();?>application/views/js/modernizr.js"></script>
	
   <!-- Java Script
   ================================================== -->
   <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
   <script>window.jQuery || document.write('<script src="<?=base_url();?>application/views/js/jquery-1.10.2.min.js"><\/script>')</script>
   <script type="text/javascript" src="<?=base_url();?>application/views/js/jquery-migrate-1.2.1.min.js"></script>

   <script src="<?=base_url();?>application/views/js/jquery.flexslider.js"></script>
   <script src="<?=base_url();?>application/views/js/waypoints.js"></script>
   <script src="<?=base_url();?>application/views/js/jquery.fittext.js"></script>
   <script src="<?=base_url();?>application/views/js/magnific-popup.js"></script>
   <script src="<?=base_url();?>application/views/js/init.js"></script>
   
   <!-- recaptcha script
   ================================================== -->
	<?php if ($current_lang==2){ ?>
	<script src='https://www.google.com/recaptcha/api.js?hl=ru'></script>
	<?php } else {?>
	<script src='https://www.google.com/recaptcha/api.js?hl=en'></script>
	<?php }?>

</head>

<body>
   <!-- Header
   ================================================== -->
   <header id="home">

	<nav id="nav-wrap">

		<a class="mobile-btn" href="#nav-wrap" title="<?=$langs['show_navigation']?>"><?=$langs['show_navigation']?></a>
		<a class="mobile-btn" href="#" title="<?=$langs['hide_navigation']?>"><?=$langs['hide_navigation']?></a>

		<ul id="nav" class="nav">
			<li class="current"><a class="smoothscroll" href="#home"><?=$langs['top_menu_home']?></a></li>
			<li><a class="smoothscroll" href="#about"><?=$langs['top_menu_about_me']?></a></li>
			<li><a class="smoothscroll" href="#resume"><?=$langs['top_menu_resume']?></a></li>
			<li><a class="smoothscroll" href="#portfolio"><?=$langs['top_menu_portfolio']?></a></li>
			<!--li><a class="smoothscroll" href="#testimonials">Testimonials</a></li-->
			<li><a class="smoothscroll" href="#contact"><?=$langs['top_menu_contact']?></a></li>
			<li class="navigation"><a href="javascript:void(0)"><?=$langs['top_menu_language_'.$current_lang];?></a>
				<ul>
					<li><a href="<?=base_url()?>settings/change_language/1"><span <?php if ($current_lang==1){ ?>class="cust_current"<?php }?>><?=$langs['top_menu_language_1']?></span></a></li>
					<li><a href="<?=base_url()?>settings/change_language/2"><span <?php if ($current_lang==2){ ?>class="cust_current"<?php }?>><?=$langs['top_menu_language_2']?></span></a></li>
				</ul>
			</li>
		</ul> <!-- end #nav -->
	</nav> <!-- end #nav-wrap -->
		<!--script>
			function load_language(value){
				$.getJSON('<?=base_url()?>settings/change_language/'+value, {}, function(data){
					location.reload();
				});
			}
		</script-->
      <div class="row banner">
         <div class="banner-text">
            <h1 class="responsive-headline"><?=$langs['home_text_1']?></h1>
            <h3><?=$langs['home_text_2']?></h3>
            <hr />
            <ul class="social">
               <li><a href="https://www.facebook.com/pavel.aleksan" target="_blank"><i class="fa fa-facebook"></i></a></li>
               <!--li><a href="#"><i class="fa fa-twitter"></i></a></li-->
               <li><a href="https://plus.google.com/u/0/104680899017182282865" target="_blank"><i class="fa fa-google-plus"></i></a></li>
               <!--li><a href="#"><i class="fa fa-linkedin"></i></a></li>
               <li><a href="#"><i class="fa fa-instagram"></i></a></li>
               <li><a href="#"><i class="fa fa-dribbble"></i></a></li-->
               <li><a href="skype:pavel_elsukov?chat"><i class="fa fa-skype"></i></a></li>
            </ul>
         </div>
      </div>

      <p class="scrolldown">
         <a class="smoothscroll" href="#about"><i class="icon-down-circle"></i></a>
      </p>

   </header> <!-- Header End -->


   <!-- About Section
   ================================================== -->
	<section id="about">
		<div class="row">
			<div class="three columns">
				<img class="profile-pic"  src="<?=base_url();?>application/views/images/profilepic2.jpg" alt="" />
			</div>

			<div class="nine columns main-col">

			<h2><?=$langs['about_text_1']?></h2>

			<p><?=$langs['about_text_2']?></p>
			<div class="row">
				<div class="columns contact-details">
					<h2><?=$langs['contact_details']?></h2>
					<p class="address">
						<span><?=$langs['pavel_elsukov']?></span><br>
						<span><a href="skype:pavel_elsukov?chat" title="<?=$langs['contact_skype']?>"><i class="fa fa-skype"></i> pavel_elsukov</a></span><br>
						<span><a href="javascript:void(0)" title="<?=$langs['contact_icq']?>"><img src="http://web.icq.com/whitepages/online?icq=615579973&img=5" title="<?=$langs['contact_icq']?>" style="position: relative;top: 5px;"/> 615579973</a></span><br>
						<span><a href="mailto:pavel.elsukov@gmail.com" title="<?=$langs['send_email']?>"><i class="fa fa-envelope"></i> pavel.elsukov@gmail.com</a></span>
					</p>
				</div>
               <!--div class="columns download">
                  <p>
                     <a href="#" class="button"><i class="fa fa-download"></i>Download Resume</a>
                  </p>
               </div-->

            </div> <!-- end row -->

         </div> <!-- end .main-col -->

      </div>

   </section> <!-- About Section End-->


   <!-- Resume Section
   ================================================== -->
   <section id="resume">

      <!-- Education
      ----------------------------------------------- -->
      <div class="row education">

         <div class="three columns header-col">
            <h1><span><?=$langs['education']?></span></h1>
         </div>

         <div class="nine columns main-col">

            <div class="row item">

               <div class="twelve columns">

                  <h3><?=$langs['marsu']?></h3>
                  <p class="info"><?=$langs['teacher']?><span>&bull;</span> <em class="date"><?=$langs['july']?> 2009</em></p>
                  <p><?=$langs['education_text']?></p>

               </div>

            </div> <!-- item end -->

         </div> <!-- main-col end -->

      </div> <!-- End Education -->


      <!-- Work
      ----------------------------------------------- -->
      <div class="row work">

         <div class="three columns header-col">
            <h1><span><?=$langs['work']?></span></h1>
         </div>

         <div class="nine columns main-col">
            <div class="row item">
               <div class="twelve columns">
                  <h3>Pilot Group</h3>
                  <p class="info"><?=$langs['enginer-developer']?><span>&bull;</span> <em class="date"><?=$langs['july']?> 2010 - <?=$langs['present']?></em></p>
                  <p><?=$langs['work_text']?></p>
               </div>
            </div> <!-- item end -->
         </div> <!-- main-col end -->
      </div> <!-- End Work -->


      <!-- Skills
      ----------------------------------------------- -->
		<div class="row skill">

			<div class="three columns header-col">
				<h1><span><?=$langs['skills']?></span></h1>
			</div>

			<div class="nine columns main-col">

				<p><?=$langs['skills_text']?></p>

				<div class="bars">
					<ul class="skills">
						<!--li><span class="bar-expand photoshop"></span><em>Photoshop</em></li>
						<li><span class="bar-expand illustrator"></span><em>Illustrator</em></li>
						<li><span class="bar-expand wordpress"></span><em>Wordpress</em></li-->
						<li><span class="bar-expand php"></span><em>PHP</em></li>
						<li><span class="bar-expand html5"></span><em>HTML5</em></li>
						<li><span class="bar-expand css"></span><em>CSS</em></li>
						<li><span class="bar-expand jquery"></span><em>jQuery</em></li>
					</ul>
				</div><!-- end skill-bars -->

			</div> <!-- main-col end -->

		</div> <!-- End skills -->

	</section> <!-- Resume Section End-->


   <!-- Portfolio Section
   ================================================== -->
   <section id="portfolio">

      <div class="row">

		<div class="twelve columns collapsed">

            <h1><?=$langs['portfolio']?></h1>

            <!-- portfolio-wrapper -->
            <div id="portfolio-wrapper" class="bgrid-quarters s-bgrid-thirds cf">


				<div class="columns portfolio-item">
					<div class="item-wrap">

						<a href="#modal-05" title="">
							<img alt="" src="<?=base_url();?>application/views/images/portfolio/module_sms_notifications_basic/image_1.png" style="width:215px; height:177px">
							<div class="overlay">
								<div class="portfolio-item-meta">
									<h5><?=$langs['projects_sms_notifications_basic_module']?></h5>
									<p><?=$langs['seo_title_sms_notifications_basic']?></p>
								</div>
							</div>
							<div class="link-icon"><i class="icon-plus"></i></div>
						</a>

					</div>
				</div> <!-- item end -->
				
				<div class="columns portfolio-item">
					<div class="item-wrap">

						<a href="#modal-04" title="">
							<img alt="" src="<?=base_url();?>application/views/images/portfolio/module_invite_friends/image_1.png" style="width:215px; height:177px">
							<div class="overlay">
								<div class="portfolio-item-meta">
									<h5><?=$langs['projects_invite_friends_module']?></h5>
									<p><?=$langs['seo_title_invite_friends']?></p>
								</div>
							</div>
							<div class="link-icon"><i class="icon-plus"></i></div>
						</a>

					</div>
				</div> <!-- item end -->

				<div class="columns portfolio-item">
					<div class="item-wrap">

						<a href="#modal-03" title="">
							<img alt="" src="<?=base_url();?>application/views/images/portfolio/module_smiles/logo.gif" style="width:215px; height:177px">
							<div class="overlay">
								<div class="portfolio-item-meta">
									<h5><?=$langs['projects_smiles_module']?></h5>
									<p><?=$langs['seo_title_smiles']?></p>
								</div>
							</div>
							<div class="link-icon"><i class="icon-plus"></i></div>
						</a>

					</div>
				</div> <!-- item end -->
				
				<div class="columns portfolio-item">
					<div class="item-wrap">

						<a href="#modal-02" title="">
							<img alt="" src="<?=base_url();?>application/views/images/portfolio/module_faces/image_5.jpg" style="width:215px; height:177px">
							<div class="overlay">
								<div class="portfolio-item-meta">
									<h5><?=$langs['projects_faces_module']?></h5>
									<p><?=$langs['seo_title_faces']?></p>
								</div>
							</div>
							<div class="link-icon"><i class="icon-plus"></i></div>
						</a>

					</div>
				</div> <!-- item end -->
				
				
				<div class="columns portfolio-item">
					<div class="item-wrap">

						<a href="#modal-01" title="">
							<img alt="" src="<?=base_url();?>application/views/images/portfolio/module_captcha/marketplace_robot_thumb.png">
							<div class="overlay">
								<div class="portfolio-item-meta">
									<h5><?=$langs['projects_captcha_module']?></h5>
									<p><?=$langs['projects_captcha_module_header']?></p>
								</div>
							</div>
							<div class="link-icon"><i class="icon-plus"></i></div>
						</a>

					</div>
				</div> <!-- item end -->

			</div> <!-- portfolio-wrapper end -->

		</div> <!-- twelve columns end -->


         <!-- Modal Popup
	      --------------------------------------------------------------- -->

		<div id="modal-01" class="popup-modal mfp-hide">
			<img class="scale-with-grid" src="<?=base_url();?>application/views/images/portfolio/module_captcha/marketplace_robot.png" alt="" />
			<div class="description-box">
				<h4><?=$langs['projects_captcha_module']?></h4>
				<p><?=$langs['projects_captcha_module_header_long']?></p>
				<span class="categories"><i class="fa fa-tag"></i><?=$langs['projects_captcha_module_tags']?></span>
			</div>
			<div class="link-box">
				<a href="<?=base_url();?>captcha"><?=$langs['button_details']?></a>
				<a class="popup-modal-dismiss"><?=$langs['button_close']?></a>
			</div>
		</div><!-- modal-01 End -->
		
		<div id="modal-02" class="popup-modal mfp-hide">
			<img class="scale-with-grid" src="<?=base_url();?>application/views/images/portfolio/module_faces/image_5.jpg" alt="" style="width: 100%;" />
			<div class="description-box">
				<h4><?=$langs['projects_faces_module']?></h4>
				<p><?=$langs['seo_title_faces']?></p>
				<span class="categories"><i class="fa fa-tag"></i><?=$langs['projects_faces_module_tags']?></span>
			</div>
			<div class="link-box">
				<a href="<?=base_url();?>faces"><?=$langs['button_details']?></a>
				<a class="popup-modal-dismiss"><?=$langs['button_close']?></a>
			</div>
		</div><!-- modal-02 End -->
		
		<div id="modal-03" class="popup-modal mfp-hide">
			<img class="scale-with-grid" src="<?=base_url();?>application/views/images/portfolio/module_smiles/logo.gif" alt="" style="width: 100%;" />
			<div class="description-box">
				<h4><?=$langs['projects_smiles_module']?></h4>
				<p><?=$langs['seo_title_smiles']?></p>
				<span class="categories"><i class="fa fa-tag"></i><?=$langs['projects_smiles_module_tags']?></span>
			</div>
			<div class="link-box">
				<a href="<?=base_url();?>smiles"><?=$langs['button_details']?></a>
				<a class="popup-modal-dismiss"><?=$langs['button_close']?></a>
			</div>
		</div><!-- modal-03 End -->
		
		<div id="modal-04" class="popup-modal mfp-hide">
			<img class="scale-with-grid" src="<?=base_url();?>application/views/images/portfolio/module_invite_friends/image_1.png" alt="" style="width: 100%;" />
			<div class="description-box">
				<h4><?=$langs['projects_invite_friends_module']?></h4>
				<p><?=$langs['seo_title_invite_friends']?></p>
				<span class="categories"><i class="fa fa-tag"></i><?=$langs['projects_invite_friends_module_tags']?></span>
			</div>
			<div class="link-box">
				<a href="<?=base_url();?>invite_friends"><?=$langs['button_details']?></a>
				<a class="popup-modal-dismiss"><?=$langs['button_close']?></a>
			</div>
		</div><!-- modal-04 End -->
		
		<div id="modal-05" class="popup-modal mfp-hide">
			<img class="scale-with-grid" src="<?=base_url();?>application/views/images/portfolio/module_sms_notifications_basic/image_1.jpg" alt="" style="width: 100%;" />
			<div class="description-box">
				<h4><?=$langs['projects_sms_notifications_basic_module']?></h4>
				<p><?=$langs['seo_title_sms_notifications_basic']?></p>
				<span class="categories"><i class="fa fa-tag"></i><?=$langs['projects_sms_notifications_basic_module_tags']?></span>
			</div>
			<div class="link-box">
				<a href="<?=base_url();?>sms_notifications_basic"><?=$langs['button_details']?></a>
				<a class="popup-modal-dismiss"><?=$langs['button_close']?></a>
			</div>
		</div><!-- modal-05 End -->


      </div> <!-- row End -->

   </section> <!-- Portfolio Section End-->



   <!-- Testimonials Section
   ================================================== --
	<section id="testimonials">

		<div class="text-container">

			<div class="row">

				<div class="two columns header-col">

					<h1><span>Client Testimonials</span></h1>

				</div>

				<div class="ten columns flex-container">

					<div class="flexslider">

						<ul class="slides">

							<li>
								<blockquote>
									<p>Your work is going to fill a large part of your life, and the only way to be truly satisfied is to do what you believe is great work. And the only way to do great work is to love what you do. If you haven't found it yet, keep looking. Don't settle. As with all matters of the heart, you'll know when you find it.</p>
								<cite>Steve Jobs</cite>
								</blockquote>
							</li> <!-- slide ends --

						</ul>

					</div> <!-- div.flexslider ends --

				</div> <!-- div.flex-container ends --

			</div> <!-- row ends --

		</div>  <!-- text-container ends --

	</section> <!-- Testimonials Section End-->


   <!-- Contact Section
   ================================================== -->
   <section id="contact">

         <div class="row section-head">
            <div class="two columns header-col">
               <h1><span><?=$langs['seo_title_welcome']?></span></h1>
            </div>
            <div class="ten columns">
                  <p class="lead"><?=$langs['contact_text']?></p>
            </div>
         </div>

         <div class="row">

            <div class="eight columns">

               <!-- form -->
               <form action="" method="post" id="contactForm" name="contactForm">
					<fieldset>

					<div>
						<label for="contactName"><?=$langs['form_your_name']?> <span class="required">*</span></label>
						<input type="text" value="" size="35" id="contactName" name="contactName">
					</div>

					<div>
						<label for="contactEmail"><?=$langs['form_email']?> <span class="required">*</span></label>
						<input type="text" value="" size="35" id="contactEmail" name="contactEmail">
					</div>

					<div>
						<label for="contactSubject"><?=$langs['form_subject']?></label>
						<input type="text" value="" size="35" id="contactSubject" name="contactSubject">
					</div>

					<div>
						<label for="contactMessage"><?=$langs['form_message']?> <span class="required">*</span></label>
						<textarea cols="50" rows="10" id="contactMessage" name="contactMessage"></textarea>
					</div>

					<div style="margin-bottom:15px; overflow:hidden;">
						<label></label>
						<div class="g-recaptcha" data-sitekey="6LdmNP8SAAAAAFOowpjp7-lKHKew_NvsVZeyCJLc" style="float:left"></div>
					</div>

                  <div>
                     <button class="submit"><?=$langs['form_send']?></button>
                     <span id="image-loader">
                        <img alt="" src="<?=base_url();?>application/views/images/loader.gif">
                     </span>
                  </div>

					</fieldset>
				   </form> <!-- Form End -->

               <!-- contact-warning -->
               <div id="message-warning"> Error</div>
               <!-- contact-success -->
				   <div id="message-success">
                  <i class="fa fa-check"></i><?=$langs['form_success_send']?><br>
				   </div>

            </div>


			<aside class="four columns footer-widgets">

				<div class="widget widget_contact">

					<h4><?=$langs['contact_details']?></h4>
					<p class="address">
						<span><?=$langs['pavel_elsukov']?></span><br>
						<span><a href="skype:pavel_elsukov?chat" title="<?=$langs['contact_skype']?>"><i class="fa fa-skype"></i> pavel_elsukov</a></span><br>
						<span><a href="javascript:void(0)" title="<?=$langs['contact_icq']?>"><img src="http://web.icq.com/whitepages/online?icq=615579973&img=5" title="<?=$langs['contact_icq']?>" style="position: relative;top: 5px;"/> 615579973</a></span><br>
						<span><a href="mailto:pavel.elsukov@gmail.com" title="<?=$langs['send_email']?>"><i class="fa fa-envelope"></i> pavel.elsukov@gmail.com</a></span>
					</p>

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

               <!--div class="widget widget_tweets">

                  <h4 class="widget-title">Latest Tweets</h4>

                  <ul id="twitter">
                     <li>
                        <span>
                        This is Photoshop's version  of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet.
                        Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum
                        <a href="#">http://t.co/CGIrdxIlI3</a>
                        </span>
                        <b><a href="#">2 Days Ago</a></b>
                     </li>
                     <li>
                        <span>
                        Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam,
                        eaque ipsa quae ab illo inventore veritatis et quasi
                        <a href="#">http://t.co/CGIrdxIlI3</a>
                        </span>
                        <b><a href="#">3 Days Ago</a></b>
                     </li>
                  </ul>

		         </div-->

            </aside>

      </div>

   </section> <!-- Contact Section End-->


   <!-- footer
   ================================================== -->
   <footer>

      <div class="row">

         <div class="twelve columns">

            <ul class="social-links">
               <li><a href="https://www.facebook.com/pavel.aleksan" target="_blank"><i class="fa fa-facebook"></i></a></li>
               <!--li><a href="#"><i class="fa fa-twitter"></i></a></li-->
               <li><a href="https://plus.google.com/u/0/104680899017182282865" target="_blank"><i class="fa fa-google-plus"></i></a></li>
               <!--li><a href="#"><i class="fa fa-linkedin"></i></a></li>
               <li><a href="#"><i class="fa fa-instagram"></i></a></li>
               <li><a href="#"><i class="fa fa-dribbble"></i></a></li-->
               <li><a href="skype:pavel_elsukov?chat"><i class="fa fa-skype"></i></a></li>
            </ul>

            <ul class="copyright">
					<li>&copy; 2014 <a href="<?=base_url();?>"><?=$langs['pavel_elsukov']?></a></li> 
               <li>Design by <a title="Styleshout" href="http://www.styleshout.com/">Styleshout</a> and <a href="http://lab.yurbasik.org.ua/">lab</a></li>   
            </ul>

         </div>

         <div id="go-top"><a class="smoothscroll" title="Back to Top" href="#home"><i class="icon-up-open"></i></a></div>

      </div>

   </footer> <!-- Footer End-->
	<?php include('tracking.php');?>
	
</body>
</html>