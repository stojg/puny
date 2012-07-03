
<?php if(defined('GAUGES_SITE_ID') && DEV_MODE == false) { ?>
<script type="text/javascript">
	var _gauges = _gauges || [];
    (function() {
      var t = document.createElement('script');
      t.type = 'text/javascript';
      t.async = true;
      t.id = 'gauges-tracker';
      t.setAttribute('data-site-id', '<?php echo GAUGES_SITE_ID; ?>');
      t.src = '//secure.gaug.es/track.js';
      var s = document.getElementsByTagName('script')[0];
      s.parentNode.insertBefore(t, s);
    })();
</script>
<?php } ?>