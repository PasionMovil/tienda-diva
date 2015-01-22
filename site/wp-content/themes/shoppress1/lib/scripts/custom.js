/////////////////////////////////////// Remove Javascript Disabled Class ///////////////////////////////////////


var el = document.getElementsByTagName("html")[0];
el.className = "";


/////////////////////////////////////// Navigation Menus ///////////////////////////////////////


jQuery(document).ready(function(){

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
	
	
	/*************************************** Dropdown Menus ***************************************/
		
	var contentwrapperPosition = jQuery("#content-wrapper").offset();
	 	
	jQuery(".nav").find(".menu li").each(function() {
	
		jQuery(this).find("ul:first").hide();	

		if(jQuery(this).find("ul").length > 0) {	
		
			jQuery("<span class='dropdown-sign' />").html("+").appendTo(jQuery(this).children(":first"));	
		
			jQuery(".nav ul > li").mouseenter(function() {
			
				var total_width = 0;			
		
				jQuery(this).find(".nav-section").each(function() {				
					total_width += jQuery(this).outerWidth() + 30; 
				});
				
				jQuery(".nav ul.menu li").find(".sub-menu").css("width",total_width + 40);		
		
				if(jQuery(this).find(".sub-menu").width() > 490) {	
					var navPosition = jQuery(this).offset(); 	
					jQuery(this).find(".sub-menu").css("left",-navPosition.left + contentwrapperPosition.left);	
				}		
		
				jQuery(this).find("ul:first").show();

			});
		
			jQuery(this).mouseleave(function() {	
				jQuery(this).find("ul:first").hide();
			});
		
		}	
		
	});
	
});


/////////////////////////////////////// Lightbox ///////////////////////////////////////


jQuery(document).ready(function(){

	jQuery("div.gallery-item .gallery-icon a").prepend('<span class="hover-image"></span>');
	jQuery("div.gallery-item .gallery-icon a").attr("rel", "prettyPhoto[gallery]");
	
	jQuery("a[rel^='prettyPhoto']").prettyPhoto({
		theme: 'light_square',
		deeplinking: false,
		social_tools: ''
	});
	
});


/////////////////////////////////////// Image Hover ///////////////////////////////////////

jQuery(document).ready(function(){

	jQuery('.hover-image, .hover-video').css({'opacity':'0'});
	jQuery("a[rel^='prettyPhoto']").hover(
		function() {
			jQuery(this).find('.hover-image, .hover-video').stop().fadeTo(750, 1);
		},
		function() {
			jQuery(this).find('.hover-image, .hover-video').stop().fadeTo(750, 0);
		})

});


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


/////////////////////////////////////// Back To Top ///////////////////////////////////////


jQuery(document).ready(function() {
	jQuery(".back-to-top").click(function() {
		jQuery("html, body").animate({ scrollTop: 0 }, 'slow');
	});
});


/////////////////////////////////////// Accordion ///////////////////////////////////////


jQuery(document).ready(function(){
	jQuery(".accordion").accordion({ header: "h3.accordion-title" });
	jQuery("h3.accordion-title").toggle(function(){
		jQuery(this).addClass("active");
		}, function () {
		jQuery(this).removeClass("active");
	});	
});


/////////////////////////////////////// Tabs ///////////////////////////////////////


jQuery(document).ready(function(){
	jQuery(".sc-tabs").tabs({
		fx: {
			height:'toggle',
			duration:'fast'
		}
	});	
});


/////////////////////////////////////// Toggle Content ///////////////////////////////////////


jQuery(document).ready(function(){
	jQuery(".toggle-box").hide(); 
	jQuery(".toggle").toggle(function(){
		jQuery(this).addClass("toggle-active");
		}, function () {
		jQuery(this).removeClass("toggle-active");
	});
	jQuery(".toggle").click(function(){
		jQuery(this).next(".toggle-box").slideToggle();
	});
});


/////////////////////////////////////// Contact Form ///////////////////////////////////////


jQuery(document).ready(function(){
	
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

});