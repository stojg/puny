<?php
	require 'partials/header.php';
	require 'partials/post.php';
?>

<div class="row">
    <div class="span8 offset2">
		<div class="comments">
			<div id="disqus_thread"></div>
		</div>
	</div>
</div>

<script type="text/javascript">
	var disqus_developer = <?php echo (int)DEV_MODE; ?>;
	var disqus_shortname = 'stojgse';
	(function() {
		var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
		dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
		(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
	})();
</script>
<?php
require 'partials/footer.php';
