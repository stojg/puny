<?php require 'partials/header.php'; ?>
<article class="post">
	<div class="entry-content">
		<form method="post">
			<div class="field">
				<label for="title">Title</label>
				<input type="text" name="title" value="<?php echo $post->getTitle();?>" />
			</div>
			<div class="field">
				<label for="publishdate">Publish date</label>
				<input type="datetime" name="publishdate" value="<?php echo $post->getDate('Y-m-d H:i:s');?>" />
			</div>
			<div class="field">
				<label for="categories">Categories</label>
				<input type="text" name="categories" value="<?php echo implode(',', $post->getCategories());?>" />
			</div>
			<div class="field">
				<textarea name="content"><?php echo $post->getContent(); ?></textarea>
			</div>
			<div class="field">
				<input type="submit" value="Save article" class="btn btn-inverse"/>
			</div>
		</form>
	</div>

	<div class="meta">
		<div class="actions">
			<a href="<?php echo $app->urlFor('single_post', array('url'=>$post->getURL())); ?>">
				View <?php echo $post->getTitle(); ?>
			</a>
		</div>
	</div>
</article>
<nav id="pagenavi">
	<div class="center"><a href="<? echo $app->urlFor('archives');?>">Blog Archives</a></div>
</nav>
<?php require 'partials/footer.php'; ?>