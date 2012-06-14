<?php
	require 'partials/header.php';
?>
	<article class="post">
		<form method="POST">
			<h1 class="title">
				<a href="<?php echo Slim::getInstance()->urlFor('single_post', array('url'=>$post->getURL())); ?>">
					<?php echo $post->getTitle(); ?>
				</a>
			</h1>
		<div class="entry-content">
			<div>
				<textarea cols="80" rows="20" name="content"><?php echo $post->getRaw(); ?></textarea>
			</div>
			<div>
				<input type="submit" />
			</div>
		</div>
		</form>
	</article>
	<nav id="pagenavi">
		<div class="center"><a href="<? echo Slim::getInstance()->urlFor('archives');?>">Blog Archives</a></div>
	</nav>
<?php
	require 'partials/footer.php';
?>