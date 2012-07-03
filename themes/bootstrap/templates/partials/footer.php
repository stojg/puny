 </div> <!-- /container -->

    <script src="<?php echo THEME_URL;?>/js/jquery.js"></script>
    <script src="<?php echo THEME_URL;?>/js/bootstrap.min.js"></script>
    <script src="<?php echo THEME_URL;?>/js/site.js"></script>
    <script type="text/javascript" src="<?php echo THEME_URL;?>/js/prettify/prettify.js"></script>
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
    <script type="text/javascript">
        var _gauges = _gauges || [];
        (function() {
          var t   = document.createElement('script');
          t.type  = 'text/javascript';
          t.async = true;
          t.id    = 'gauges-tracker';
          t.setAttribute('data-site-id', '4feef941613f5d5a4600004d');
          t.src = '//secure.gaug.es/track.js';
          var s = document.getElementsByTagName('script')[0];
          s.parentNode.insertBefore(t, s);
        })();
    </script>
  </body>
</html>
