
<?php require 'partials/header.php'; ?>
<div class="span12">
	<div class="row">
		<h1>Facebook</h1>
		<ul class="thumbnails">
		<?php
			$i = 0;
			foreach($images as $img) { 
			$i++;
		?>
  			<li class="span4">
				<div class="img-polaroid">
					<img src="<?php echo $img['src_big']; ?>" height="<?php echo $img['src_big_height']; ?>" width="<?php echo $img['src_big_width']; ?>" />
					<br />
					<small>
						<a href="<?php echo $app->urlFor('download'); ?>?link=<?php echo urlencode($img['src_big']);?>">Download</a>
						<?php echo $img['caption'];?>
					</small>
				</div>
			</li>
			<?php if($i%3==0) { ?>
		</ul>
		<ul class="thumbnails">
				<?php } ?>
			<?php } ?>
		</ul>
	</div>
</div>
<?php require 'partials/footer.php'; ?>