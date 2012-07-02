<?php require 'partials/header.php'; ?>

<div class="row">
	<div class="span8 offset2">
		<h1>Filed under <?php echo ucfirst($category); ?></h1>
	</div>
</div>
<?php foreach($posts as $post) { ?>
<div class="row">
	<div class="span8 offset2">
		<article>
			<header>
				<h2>
					<a href="<?php echo $app->urlFor('single_post', array('url'=>$post->basename())); ?>">
						<?php echo $post->getTitle(); ?>
					</a>
				</h2>
				<p>
					<time datetime="<?php echo $post->getDate('c'); ?>" pubdate="pubdate">
						<?php echo $post->getDate('M, j, Y '); ?>
					</time>
					<?php if(count($post->getCategories())) { echo ' &mdash; ';} ?>
					<?php foreach($post->getCategories() as $category) { ?>
					<a class='category' href="<? echo $app->urlFor('category', array('name'=>$category)); ?>">
						<?php echo $category; ?>
					</a>
					<?php } ?>
				</p>
			</header>
			<?php echo $post->getDescription(); ?>
		</article>
	</div>
</div>
<?php } ?>

<?php require 'partials/footer.php'; ?>