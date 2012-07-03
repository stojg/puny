<?php
	require 'partials/header.php';
	require 'partials/post.php';
?>

<div class="row">
    <div class="span8 offset2">
<div class="comments">
	<div id="disqus_thread"></div>
	<script type="text/javascript">
	var disqus_developer = <?php echo (int)DEV_MODE; ?>;
	var disqus_shortname = 'stojgse';
	/* * * DON'T EDIT BELOW THIS LINE * * */
	(function() {
		var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
		dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
		(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
	})();
	</script>
	<noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
	<a href="http://disqus.com" class="dsq-brlink">blog comments powered by <span class="logo-disqus">Disqus</span></a>
</div>
</div>
</div>
<?php
require 'partials/footer.php';