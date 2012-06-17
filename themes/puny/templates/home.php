<?php require 'partials/header.php'; ?>
	<?php foreach($posts as $post) { ?>
	<?php require 'partials/post.php'; ?>
	<?php } ?>
	<nav id="pagenavi">
		<div class="center"><a href="<? echo $app->urlFor('archives');?>">Blog Archives</a></div>
	</nav>
<?php require 'partials/footer.php'; ?>