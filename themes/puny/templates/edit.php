<?php require 'partials/header.php'; ?>
<article class="post">
	<?php if(isset($flash) && $flash) { ?>
	<div class="flashmessage ">
		<?php foreach($flash->getMessages() as $type => $message) { ?>
			<div class="<?php echo $type; ?>"><?php echo $message; ?></div>
		<?php } ?>
	</div>
	<?php } ?>
	<div class="">
		<form method="post">
			<div class="field">
				<div class="field">
					<label for="title">Title</label>
					<input size="60" type="text" name="title" value="<?php echo $post->getTitle();?>" placeholder="Title" />
				</div>
				<div class="field">
					<label for="categories">Categories</label>
					<input size="60" type="text" name="categories" value="<?php echo implode(',', $post->getCategories());?>" placeholder="Categories separated with commas" />
				</div>
				<div class="field">
					<label for="date">Date</label>
					<input type="datetime" name="date" value="<?php echo $post->getDate('Y-m-d H:i');?>" placeholder="<?php echo date('Y-m-d H:i'); ?>" />
				</div>
				<div class="field">
					<label for="content">Content</label>
					<textarea name="content" rows="5" cols="75"><?php echo $post->getContent(); ?></textarea>
				</div>
				<div class="field">
					<input class="uibutton large confirm" type="submit" value="Save" />
				</div>
			</div>
		</form>
	</div>
</article>
<nav id="pagenavi">
	<div class="center"><a href="<? echo $app->urlFor('archives');?>">Blog Archives</a></div>
</nav>
<?php require 'partials/footer.php'; ?>