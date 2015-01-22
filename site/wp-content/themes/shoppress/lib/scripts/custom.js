/////////////////////////////////////// Remove Javascript Disabled Class ///////////////////////////////////////


var el = document.getElementsByTagName("html")[0];
el.className = "";


/////////////////////////////////////// Image Preloader ///////////////////////////////////////


jQuery(function () {
	jQuery('.preload').hide();
});

var i = 0;
var int=0;
jQuery(window).bind("load", function() {
	var int = setInterval("doThis(i)",100);
});

function doThis() {
	var images = jQuery('.preload').length;
	if (i >= images) {
		clearInterval(int);
	}
	jQuery('.preload:hidden').eq(0).fadeIn(400);
	i++;
}


/////////////////////////////////////// Document Ready ///////////////////////////////////////


jQuery(document).ready(function(){

	"use strict";
	

	/////////////////////////////////////// Navigation Menus ///////////////////////////////////////


	/*************************************** Mobile Menu ***************************************/	
	
	jQuery("<option />", {"selected": "selected", "value": "", "text": "Navigation"}).prependTo(".nav select");
		
	jQuery(".mobile-menu").change(function() {
		window.location = jQuery(this).find("option:selected").val();
	});
	
	
	/*************************************** Nav Titles ***************************************/	
	
	jQuery(".sub-menu .nav-title").each(function() {
		jQuery(this).nextUntil(".nav-title").andSelf().wrapAll("<div class='nav-section'></div>");
	});


	/*************************************** Nav Text ***************************************/	
	
	jQuery(".sub-menu .nav-text a").contents().unwrap();
	
	
	/*************************************** Mega Menus ***************************************/	
		
	jQuery(".nav > ul > li").each(function() {

		if(jQuery(this).find("ul").length > 0) {	
		
			jQuery("<span class='dropdown-sign' />").html("+").appendTo(jQuery(this).children(":first"));	
		
			jQuery(this).mouseenter(function() {
			
				var total_width = 0;			
		
				jQuery(this).find(".nav-section").each(function() {				
					total_width += jQuery(this).outerWidth() + 30; 
				});
				
				jQuery(this).find(".sub-menu").css("width",total_width + 40);			

			});
		
		}	
		
	});	
	
	
	/////////////////////////////////////// Lightbox ///////////////////////////////////////


	jQuery("div.gallery-item .gallery-icon a").prepend('<span class="hover-image"></span>');
	jQuery("div.gallery-item .gallery-icon a").attr("rel", "prettyPhoto[gallery]");
	
	jQuery("a[rel^='prettyPhoto']").prettyPhoto({
		theme: 'light_square',
		deeplinking: false,
		social_tools: ''
	});


	/////////////////////////////////////// Image Hover ///////////////////////////////////////


	jQuery('.hover-image, .hover-video').css({'opacity':'0'});
	jQuery("a[rel^='prettyPhoto']").hover(
		function() {
			jQuery(this).find('.hover-image, .hover-video').stop().fadeTo(750, 1);
		},
		function() {
			jQuery(this).find('.hover-image, .hover-video').stop().fadeTo(750, 0);
		}
	);


	/////////////////////////////////////// Back To Top ///////////////////////////////////////


	jQuery(".back-to-top").click(function() {
		jQuery("html, body").animate({ scrollTop: 0 }, 'slow');
	});
	

	/////////////////////////////////////// Accordion ///////////////////////////////////////


	jQuery(".accordion").accordion({ header: "h3.accordion-title" });
	jQuery("h3.accordion-title").toggle(function(){
		jQuery(this).addClass("active");
		}, function () {
		jQuery(this).removeClass("active");
	});	
	

	/////////////////////////////////////// Tabs ///////////////////////////////////////


	jQuery(".sc-tabs").tabs({
		fx: {
			height:'toggle',
			duration:'fast'
		}
	});
	

	/////////////////////////////////////// Toggle Content ///////////////////////////////////////


	jQuery(".toggle-box").hide(); 
	jQuery(".toggle").toggle(function(){
		jQuery(this).addClass("toggle-active");
		}, function () {
		jQuery(this).removeClass("toggle-active");
	});
	jQuery(".toggle").click(function(){
		jQuery(this).next(".toggle-box").slideToggle();
	});
	

	/////////////////////////////////////// Contact Form ///////////////////////////////////////


	jQuery('#contact-form').submit(function() {

		jQuery('.contact-error').remove();
		var hasError = false;
		jQuery('.requiredFieldContact').each(function() {
			if(jQuery.trim(jQuery(this).val()) == '') {
				jQuery(this).addClass('input-error');
				hasError = true;
			} else if(jQuery(this).hasClass('email')) {
				var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
				if(!emailReg.test(jQuery.trim(jQuery(this).val()))) {
					jQuery(this).addClass('input-error');
					hasError = true;
				}
			}
		});
	
	});
				
	jQuery('#contact-form .contact-submit').click(function() {
		jQuery('.loader').css({display:"block"});
	});	


	/////////////////////////////////////// Prevent Empty Search - Thomas Scholz http://toscho.de ///////////////////////////////////////


	(function($) {
		$.fn.preventEmptySubmit = function(options) {
			var settings = {
				inputselector: "#searchbar",
				msg          : emptySearchText
			};
			if (options) {
				$.extend(settings, options);
			}
			this.submit(function() {
				var s = $(this).find(settings.inputselector);
				if(!s.val()) {
					alert(settings.msg);
					s.focus();
					return false;
				}
				return true;
			});
			return this;
		};
	})(jQuery);

	jQuery('#searchform').preventEmptySubmit();
	
	
});