<?php require 'partials/header.php'; ?>

<div class="row">
	<div class="span8 offset2">
		<h1>Files</h1>
		<ul class="thumbnails">
		<?php foreach($files as $file) { ?>
			<li class="span2">
				<img src="<?php echo $file->getURL(200, 200); ?>" class="img-polaroid"/>
			</li>
		<?php } ?>
		</ul>
	</div>
</div>

<?php require 'partials/footer.php'; ?>