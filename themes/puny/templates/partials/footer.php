		</div>
		<footer id="footer" class="inner">
			Copyright &copy; 2012 Stig Lindqvist
		</footer>
		<script src="<?php echo THEME_URL;?>javascripts/minified.js"></script>
		<?php /*
		<script src="<?php echo THEME_URL;?>javascripts/jquery.js"></script>
		<script src="<?php echo THEME_URL;?>javascripts/jquery.autosize.js"></script>
		<script src="<?php echo THEME_URL;?>javascripts/jquery.fancybox.pack.js"></script>
		<script src="<?php echo THEME_URL;?>javascripts/twitter.js"></script>
		<script src="<?php echo THEME_URL;?>javascripts/slash.js"></script>
		<script src="<?php echo THEME_URL;?>javascripts/puny.js "></script>
		*/ ?>
		<script type="text/javascript">
			(function($){
				$('.fancybox').fancybox();
			})(jQuery);
		</script>
		<script type="text/javascript">
			(function($){
				$('#banner').getTwitterFeed('stojg', 4, false);
			})(jQuery);
		</script>
		<?php if(defined('GOOGLE_ANALYTICS_CODE') && GOOGLE_ANALYTICS_CODE) { ?>
		<script type="text/javascript">
			var _gaq = _gaq || [];
			_gaq.push(['_setAccount', '<?php echo GOOGLE_ANALYTICS_CODE; ?>']);
			_gaq.push(['_trackPageview']);
			(function() {
				var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
				ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
				var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			})();
		</script>
		<?php } ?>
		<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
	</body>
</html>
