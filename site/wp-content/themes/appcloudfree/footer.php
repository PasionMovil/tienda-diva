		<footer id="footer">
			<nav id="bottom-nav">
				<ul id="social">
					<li><a href="http://feeds.feedburner.com/tokokoo"><img src="<?php bloginfo('stylesheet_directory'); ?>/img/ico_rss.png" width="15" height="15" /></a></li>
					<li><a href="http://www.twitter.com/tokokoo"><img src="<?php bloginfo('stylesheet_directory'); ?>/img/ico_twit.png" width="33" height="15" /></a></li>
				</ul>
				
				<div id="bottom-site-nav">
					<small>Copyright&copy;2011 <?php bloginfo( 'name' ); ?></small>
<?php				
				if (has_nav_menu('footer')):
						wp_nav_menu(array('theme_location' => 'footer','menu_id'=>'bottom-site-menu','container'=>'','menu_class'=>''));
				endif;
?>					

				<div id="credits">Powered By <a href="http://wordpress.org">WordPress</a> and <a href="http://getshopped.org">WPEC</a>. Designed by <a href="http://tokokoo.com"><img src="<?php bloginfo('stylesheet_directory'); ?>/img/tokokoo.png" alt="Tokokoo.com" title="Tokokoo.com" /></a></div>			
			</nav>
		</footer>
	</section>
<?php
	wp_footer();
?>		<script type="text/javascript">	  var _gaq = _gaq || [];	  _gaq.push(['_setAccount', 'UA-4541673-6']);	  _gaq.push(['_setDomainName', '.tokokoo.com']);	  _gaq.push(['_trackPageview']);	  (function() {		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);	  })();	</script>
</body>
</html>