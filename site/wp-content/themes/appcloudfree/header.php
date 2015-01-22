<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'appcloud' ), max( $paged, $page ) );

	?></title>
	
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />	
	
	<link media="screen" rel="stylesheet" type="text/css" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
	
	<?php wp_head(); ?>
	
	<?php if( is_home() ) { ?>
	<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/script/stepcarousel.js"></script>
	<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/script/html5.js"></script>	
		<!-- Step Carousel Viewer script- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com) -->	
	<script type="text/javascript">
		/* <![CDATA[ */
		stepcarousel.setup({
		galleryid: 'slider',
		beltclass: 'belt', //class of inner "belt" DIV containing all the panel DIVs
		panelclass: 'featured-content', //class of panel DIVs each holding content
		panelbehavior: {speed:300, wraparound:true, persist:true},
			autostep: {enable:true, moveby:1, pause:3000},
			defaultbuttons: {enable: false},
		contenttype: ['inline']
		});
		stepcarousel.setup({
		galleryid: 'slider2',
		beltclass: 'belt', //class of inner "belt" DIV containing all the panel DIVs
		panelclass: 'item', //class of panel DIVs each holding content
		panelbehavior: {speed:300, wraparound:true, persist:true},
			autostep: {enable:false, moveby:1, pause:3000},
			defaultbuttons: {enable: false},
		contenttype: ['inline']
		});		
		/* ]]> */
	</script>
	<?php } ?>
	
	
	<script type="text/javascript">
		var $j = jQuery.noConflict();			
		function equalHeight(one,two) {
			var tallest = 0;
			if (one.height() > two.height())
				two.height( one.height() + 25 );
			else
				one.height( two.height() + 25 );
		}


		$j(document).ready(function() {
			equalHeight($j("#sidebar"), $j("#main-content"));
		});		
	</script>	
</head>
<body>
	<section id="wrapper">
		<header id="site-header">
			<hgroup>
				<h1 id="site-title"><a href="<?php echo home_url( '/' ); ?>" title="<?php bloginfo( 'name' );?>"><?php bloginfo( 'name' );?></a></h1>
				<h2 id="site-tagline"><?php bloginfo( 'description' ); ?></h2>
			</hgroup>	
			<nav id="topnav">
				<ul id="log">
					<?php wp_register(); ?>
					<li><?php wp_loginout(); ?></li>
				</ul>
<?php				
				if (has_nav_menu('header')):
						wp_nav_menu(array('theme_location' => 'header','menu_id'=>'site-nav','container'=>'','menu_class'=>''));
				endif;
?>												
			</nav>
		</header>
