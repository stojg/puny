<?php
	require 'partials/header.php';
?>
	<?php foreach($posts as $post) { ?>
	<article class="post">
			<h1 class="title">
				<a href="<?php echo Slim::getInstance()->urlFor('single_post', array('url'=>$post->getURL())); ?>">
					<?php echo $post->getTitle(); ?>
				</a>
			</h1>
		<div class="entry-content">
			<?php echo $post->toHTML(); ?>
		</div>
		<div class="meta">
			<div class="date">
				<time datetime="<?php echo $post->getDate('c'); ?>" pubdate data-updated="true">
					<?php echo $post->getDate('M, j'); ?><span><?php echo $post->getDate('S'); ?></span>, <?php echo $post->getDate('Y'); ?>
				</time></div>
			<div class="tags">
				<?php foreach($post->getCategories() as $category) { ?>
				<a class='category' href="<? echo Slim::getInstance()->urlFor('category', array('name'=>$category)); ?>">
					<?php echo $category; ?>
				</a>
				<?php } ?>
			</div>
		</div>
	</article>
	<?php } ?>
	<nav id="pagenavi">
		<div class="center"><a href="<? echo Slim::getInstance()->urlFor('archives');?>">Blog Archives</a></div>
	</nav>
<?php
	require 'partials/footer.php';
?>