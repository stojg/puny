
<?php require 'partials/header.php'; ?>
<div class="span12">
	<div class="row">
		<h1>Instagrams</h1>
		<ul class="thumbnails">
		<?php
			$i = 0;
			foreach($images as $image) { 
			$i++;
		?>
  			<li class="span3">
				<?php $srcURL = $image['images']['standard_resolution']['url']; ?>
				<?php $img = $image['images']['low_resolution']; ?>
				<div>
					<img src="<?php echo $img['url']; ?>" height="<?php echo $img['height']; ?>" width="<?php echo $img['width']; ?>" class="img-polaroid" />
					<br />
					<small>
						<a href="<?php echo $app->urlFor('download'); ?>?link=<?php echo urlencode($srcURL);?>">Download</a>
						<?php echo $image['caption']['text'];?>
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