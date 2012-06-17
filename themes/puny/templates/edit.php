<?php require 'partials/header.php'; ?>

<article class="post">

	<div class="entry-content">
		<form method="post">
			<div class="field">
				<input size="60" type="text" name="title" value="<?php echo $post->getTitle();?>" placeholder="Title" />
			</div>
			<div class="input-prepend field">
				<span class="add-on"><i class="icon-tags"></i></span>
				<input size="40" type="text" name="categories" value="<?php echo implode(',', $post->getCategories());?>" placeholder="Categories separated with commas" />
			
				<span class="add-on"><i class="icon-calendar"></i></span>
				<input type="datetime" name="date" value="<?php echo $post->getDate('Y-m-d H:i');?>" placeholder="<?php echo date('Y-m-d H:i'); ?>" />
			</div>

			<div class="input-prepend field">
				<textarea name="content" rows="5"><?php echo $post->getContent(); ?></textarea>
			</div>

			<div class="input-prepend field">
				<input type="submit" value="Save" class="btn-small btn-inverse "/>
			</div>
		</form>
	</div>

	<div class="meta">
		<div class="view">
			<a href="<?php echo $app->urlFor('single_post', array('url'=>$post->basename())); ?>">
				View post
			</a>
		</div>
	</div>
</article>
<nav id="pagenavi">
	<div class="center"><a href="<? echo $app->urlFor('archives');?>">Blog Archives</a></div>
</nav>
<?php require 'partials/footer.php'; ?>