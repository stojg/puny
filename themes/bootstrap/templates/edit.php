<?php require 'partials/header.php'; ?>
<div class="row">
    <div class="span8 offset2">
		<?php if(isset($flash) && $flash) { ?>
		<div class="flashmessage ">
			<?php foreach($flash->getMessages() as $type => $message) { ?>
				<div class="<?php echo $type; ?>"><?php echo $message; ?></div>
			<?php } ?>
		</div>
		<?php } ?>
		<div class="">
			<form method="post" class="well">
				
				
				<label for="title">Title</label>
				<input size="60" type="text" name="title" value="<?php echo $post->getTitle();?>" placeholder="Title" />
			
				<label for="categories">Categories</label>
				<input size="60" type="text" name="categories" value="<?php echo implode(',', $post->getCategories());?>" placeholder="Categories separated with commas" />
			
				<label for="date">Date</label>
				<input type="datetime" name="date" value="<?php echo $post->getDate('Y-m-d H:i');?>" placeholder="<?php echo date('Y-m-d H:i'); ?>" />
			
				<label for="content">Content</label>
				<textarea name="content" rows="5" cols="75"><?php echo $post->getContent(); ?></textarea>
			
				<div class="form-actions">			
					<input class="btn btn-primary" type="submit" value="Save" />
					<a href="<?php echo $app->urlFor('index'); ?>" class="btn" />Cancel</a>
          		</div>
				

			</form>
		</div>
	</div>
</div>

<?php require 'partials/footer.php'; ?>