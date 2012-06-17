<?php
	require 'partials/header.php';
?>

	<div id="content" class="inner">
	<section class="archives">
		<h1 class="year">Archives</h1>
		<?php foreach($posts as $post) { ?>
		<article>
			<h1 class="title">
				<a href="<?php echo $app->urlFor('single_post', array('url'=>$post->basename())); ?>">
					<?php echo $post->getTitle(); ?>
				</a>
			</h1>
			<div class="meta">
				<span class="date">
					<time datetime="<?php echo $post->getDate('c'); ?>" pubdate data-updated="true">
						<?php echo $post->getDate('M, j'); ?>
					</time>
				</span>
				<span class="tags">
				<?php foreach($post->getCategories() as $category) { ?>
					<a class='category' href="<? echo $app->urlFor('category', array('name'=>$category)); ?>">
						<?php echo $category; ?>
					</a>
				<?php } ?>
				</span>
			</div>
		</article>
		<?php } ?>
	</section>
	</div>
<?php
	require 'partials/footer.php';
?>