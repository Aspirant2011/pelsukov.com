/*-----------------------------------------------------------------------------------
/*
/* Init JS
/*
-----------------------------------------------------------------------------------*/

 jQuery(document).ready(function($) {

/*----------------------------------------------------*/
/* FitText Settings
------------------------------------------------------ */

    setTimeout(function() {
	   $('h1.responsive-headline').fitText(1, { minFontSize: '40px', maxFontSize: '90px' });
	 }, 100);


/*----------------------------------------------------*/
/* Smooth Scrolling
------------------------------------------------------ */

   $('.smoothscroll').on('click',function (e) {
	    e.preventDefault();

	    var target = this.hash,
	    $target = $(target);

	    $('html, body').animate({
	        'scrollTop': $target.offset().top
	    }, 800, 'swing', function () {
	        window.location.hash = target;
	    });
	});


/*----------------------------------------------------*/
/* Highlight the current section in the navigation bar
------------------------------------------------------*/

	var sections = $("section");
	var navigation_links = $("#nav-wrap a");

	sections.waypoint({

      handler: function(event, direction) {

		   var active_section;

			active_section = $(this);
			if (direction === "up") active_section = active_section.prev();

			var active_link = $('#nav-wrap a[href="#' + active_section.attr("id") + '"]');

         navigation_links.parent().removeClass("current");
			active_link.parent().addClass("current");

		},
		offset: '35%'

	});


/*----------------------------------------------------*/
/*	Make sure that #header-background-image height is
/* equal to the browser height.
------------------------------------------------------ */

   $('header').css({ 'height': $(window).height() });
   $(window).on('resize', function() {

        $('header').css({ 'height': $(window).height() });
        $('body').css({ 'width': $(window).width() })
   });

/*----------------------------------------------------*/
/*	Modal Popup
------------------------------------------------------*/

    $('.item-wrap a').magnificPopup({

       type:'inline',
       fixedContentPos: false,
       removalDelay: 200,
       showCloseBtn: false,
       mainClass: 'mfp-fade'

    });

    $(document).on('click', '.popup-modal-dismiss', function (e) {
    		e.preventDefault();
    		$.magnificPopup.close();
    });


/*----------------------------------------------------*/
/*	Flexslider
/*----------------------------------------------------*/
   $('.flexslider').flexslider({
      namespace: "flex-",
      controlsContainer: ".flex-container",
      animation: 'slide',
      controlNav: true,
      directionNav: true,
      smoothHeight: true,
      slideshowSpeed: 7000,
      animationSpeed: 600,
      randomize: false,
   });

/*----------------------------------------------------*/
/*	checkpayd form
------------------------------------------------------*/

   $('form#paydForm button.submit').click(function() {

      $('#image-loader').fadeIn();

      var script = $('#paydForm #script').val();
      var payment_system = $('#paydForm #payment_system').val();
      var product = 'module_sms_notifications_basic';
      var name = $('#paydForm #name').val();
      var email = $('#paydForm #email').val();
      var comment = $('#paydForm #comment').val();
      var recaptcha = $('#paydForm #g-recaptcha-response').val();
	  
      var data = 'script=' + script + '&payment_system=' + payment_system + '&product=' + product +
               '&name=' + name + '&email=' + email + '&comment=' + comment + '&recaptcha=' + recaptcha;

      $.ajax({

	      type: "POST",
	      url: "form/checkPaymentform",
	      data: data,
	      dataType: "json",
	      success: function(data) {

            if (data.error) { 
				$('#image-loader').fadeOut();
				$('#message-warning').html(data.error);
				$('#message-warning').fadeIn();
				$('html, body').animate({
					scrollTop: $('#message-warning').offset().top-180 },
					300
				);
            }
            else {
				$('#paydForm #id_transaction').val(data.id_transaction);
				$('#paydForm #product').val('module_sms_notifications_basic');
				$('#paydForm').submit();
            }
			grecaptcha.reset();

	      }

      });
      return false;
   });

	$('form#paydForm .payment_systems i.fa').click(function() {
		$('form#paydForm .payment_systems i.fa').removeClass('selected');
		$(this).addClass('selected');
		$('#payment_system').val($(this).attr('system'));
	});
	
	$('.tooltip').tooltipster({
		position: 'right'
	});
});








