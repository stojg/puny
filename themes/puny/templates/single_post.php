<?php
	require 'partials/header.php';
?>
	<article class="post">
			<h1 class="title">
				<a href="<?php echo $app->urlFor('single_post', array('url'=>$post->getURL())); ?>">
					<?php echo $post->getTitle(); ?>
				</a>
			</h1>
		<div class="entry-content">
			<?php if($user->valid()) { ?>
				<div>
					<a href="<?php echo $app->urlFor('edit', array('url'=>$post->getURL())); ?>">Edit this post</a>
				</div>
			<?php } ?>
			<?php echo $post->toHTML(); ?>
		</div>
		<div class="meta">
			<div class="date">
				<time datetime="<?php echo $post->getDate('c'); ?>" pubdate data-updated="true">
					<?php echo $post->getDate('M, j'); ?><span><?php echo $post->getDate('S'); ?></span>, <?php echo $post->getDate('Y'); ?>
				</time></div>
			<div class="tags">
				<?php foreach($post->getCategories() as $category) { ?>
				<a class='category' href="<? echo $app->urlFor('category', array('name'=>$category)); ?>">
					<?php echo $category; ?>
				</a>
				<?php } ?>
			</div>
		</div>
	</article>
<?php
	require 'partials/footer.php';
?>