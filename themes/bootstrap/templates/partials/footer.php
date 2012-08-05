    </div> <!-- /container -->
    <script src="<?php echo THEME_URL; ?>js/jquery-1.7.2.min.js"></script>
    <script src="<?php echo THEME_URL; ?>js/bootstrap.min.js"></script>
    <script src="<?php echo THEME_URL; ?>js/site.min.js"></script>
    <?php require TEMPLATE_PATH.'partials/google-analytics.php'; ?>
    <?php require TEMPLATE_PATH.'partials/gauges-analytics.php'; ?>
    <!-- Place this render call where appropriate -->
	<script type="text/javascript">
		(function() {
			var po = document.createElement('script');
			po.type = 'text/javascript'; po.async = true;
			po.src = 'https://apis.google.com/js/plusone.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
	  })();

	</script>
	<script src="//yandex.st/highlightjs/7.0/highlight.min.js"></script>
	<script>hljs.initHighlightingOnLoad();</script>
  </body>
</html>
