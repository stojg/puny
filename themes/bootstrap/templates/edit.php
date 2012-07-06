<?php require 'partials/header.php'; ?>
<div class="row">
    <div class="span12 ">
    	
		<?php foreach($flash->getMessages() as $type => $message) { ?>
		<div class="alert alert-<?php echo $type; ?>">
		 	<button class="close" data-dismiss="alert">×</button>
		 	<b><?php echo ucfirst($type); ?></b> - <?php echo $message; ?>
		</div>
		<?php } ?>
		
		<form method="post" class="well ">
			<fieldset>
				<div class="control-group">
					<div class="controls">
						<div class="input-prepend">
              				<span class="add-on"><i class="icon-file"></i></span>
							<input class="span7" type="text" name="title" value="<?php echo $post->getTitle();?>" placeholder="Title" />
						</div>
					</div>
				</div>
				<div class="control-group">
					
					<div class="controls">
						<div class="input-prepend">
              				<span class="add-on"><i class="icon-tags"></i></span>
							<input class="span7" type="text" name="categories" value="<?php echo implode(',', $post->getCategories());?>" placeholder="Categories separated with commas" />
						</div>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<div class="input-prepend">
              				<span class="add-on"><i class="icon-calendar"></i></span>
							<input class="span3" type="datetime" name="date" value="<?php echo $post->getDate('Y-m-d H:i');?>" placeholder="<?php echo date('Y-m-d H:i'); ?>" />
						</div>
					</div>
				</div>

				<div class="control-group">
					<div class="controls">
						<div class="controls">
							<label class="radio">
								<input type="radio" name="draft" id="draftFalse" value="0" <?php echo ($post->getDraft())?'':'checked="checked"'; ?>>
								This post is published
							</label>
							<label class="radio">
								<input type="radio" name="draft" id="draftTrue" value="1" <?php echo (!$post->getDraft())?'':'checked="checked"'; ?>>
								This post is hidden
								</label>
							</div>
					</div>
				</div>


				
				<div class="control-group">
					<div class="controls">
						<div class="input-prepend">
							<span class="add-on"><i class="icon-align-left"></i></span>
							<textarea class="span7" name="content" rows="5"><?php echo $post->getContent(); ?></textarea>
						</div>
					</div>
				</div>
				<div class="control-group">
					<input class="btn btn-primary" type="submit" value="Save" />
					<a class="btn" href="<?php echo $app->urlFor('single_post', array('url'=>$post->basename())); ?>">Cancel</a>
          		</div>
      		</fieldset>
		</form><!-- /form -->

	</div> <!-- /.span12 -->
</div> <!-- /.row -->

<?php require 'partials/footer.php'; ?>