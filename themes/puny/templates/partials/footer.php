		</div>
		<footer id="footer" class="inner">
			Copyright &copy; 2012 Stig Lindqvist
		</footer>
		<script src="<?php echo THEME_URL;?>javascripts/minified.js"></script>
		
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
		<script type="text/javascript">
			var _gaq = _gaq || [];
			_gaq.push(['_setAccount', 'UA-20319066-61']);
			_gaq.push(['_trackPageview']);

			(function() {
				var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
				ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
				var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			})();
		</script>
	</body>
</html>