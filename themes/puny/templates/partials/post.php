<article class="post">
		<h1 class="title">
			<a href="<?php echo $app->urlFor('single_post', array('url'=>$post->basename())); ?>">
				<?php echo $post->getTitle(); ?>
			</a>
		</h1>
	<div class="entry-content">
		<?php echo $post->getContentHTML(); ?>
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
		<?php if($user->valid()) { ?>
		<div class="edit">
			<a href="<?php echo $app->urlFor('edit', array('url'=>$post->basename())); ?>">Edit post</a>
		</div>
		<?php } ?>
		<div class="g-plusone" data-size="small" data-width="198" data-annotation="inline" data-href="<?php echo $app->urlFor('single_post', array('url'=>$post->basename())); ?>"></div> 
	</div>
</article>