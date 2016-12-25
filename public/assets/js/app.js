$(document).ready(function(){

	/* Scroll */
	if(jQuery.browser.mobile == false) {
		function initScroll(){
			$('.custom-scroll').jScrollPane({
				autoReinitialise: true,
				autoReinitialiseDelay: 100
			});
		}

		initScroll();

		$(window).resize(function() {
			initScroll();
		});
	}

	/* Scroll - if mobile */
	if(jQuery.browser.mobile == true) {
		$('.custom-scroll').css('overflow-y','scroll');
	}


	function WidthChange(mq) {
		if (mq.matches) {
			$('body').addClass('compact-sidebar');
			$('.site-sidebar li.with-sub').find('>ul').slideUp();
		} else {
			$('body').removeClass('compact-sidebar');
			sidebarIfActive();
		}
	}
function setHeight() {
    windowHeight = $(window).innerHeight() - $('footer').innerHeight() - 2;
    $('#maps-container').css('min-height', windowHeight);
    $('#maps-container').css('height', windowHeight);
  };
  setHeight();
  
  $(window).resize(function() {
    setHeight();
  });

    /* Sidebar - on click */
	$('.site-sidebar li.with-sub > a').click(function() {
		if (!$('body').hasClass('compact-sidebar')) {
			if ($(this).parent().hasClass('active')) {
				$(this).parent().removeClass('active');
				$(this).parent().find('>ul').slideUp();
			} else {
				if (!$(this).parent().parent().closest('.with-sub').length) {
					$('.site-sidebar li.with-sub').removeClass('active').find('>ul').slideUp();
				}
				$(this).parent().addClass('active');
				$(this).parent().find('>ul').slideDown();
			}
		}
	});

	/* Sidebar - if active */
	function sidebarIfActive(){
		$('.site-sidebar ul > li:not(.with-sub)').removeClass('active');
		var url = window.location;
	    var element = $('.site-sidebar ul > li > a').filter(function () {
	        return this.href == url || url.href.indexOf(this.href) == 0;
	    });
		element.parent().addClass('active');

		$('.site-sidebar li.with-sub').removeClass('active').find('>ul').hide();
		var url = window.location;
	    var element = $('.site-sidebar ul li ul li a').filter(function () {
	        return this.href == url || url.href.indexOf(this.href) == 0;
	    });
		element.parent().addClass('active');
		element.parent().parent().parent().addClass('active');

	    if(!$('body').hasClass('compact-sidebar')) {
			element.parent().parent().slideDown();
	    }
	}

	sidebarIfActive();

	/* Sidebar - show and hide */
	$('.site-header .sidebar-toggle-first').click(function() {
		if ($('body').hasClass('site-sidebar-opened')) {
			$('body').removeClass('site-sidebar-opened');
			if(jQuery.browser.mobile == false){
				$('html').css('overflow','auto');
			}
		} else {
			$('body').addClass('site-sidebar-opened');
			if(jQuery.browser.mobile == false){
				$('html').css('overflow','hidden');
			}
		}
	});
	
		
	});