<?php require 'partials/header.php'; ?>
<div class="row">
    <div class="span4 offset4">
    	
    	<?php foreach($flash->getMessages() as $type => $message) { ?>
				<div class="alert alert-<?php echo $type; ?>">
				 	<button class="close" data-dismiss="alert">×</button>
				 	<b><?php echo ucfirst($type); ?></b> - <?php echo $message; ?>
				</div>
			<?php } ?>
		<form method="post">
			
			<input type="hidden" name="action" value="login" />
			
			<div class="control-group">	
				<div class="controls">
					<input tabindex="1" type="email" class="input span4" placeholder="Username" id="username" name="username">
				</div>
			</div>
			<div class="control-group">
				<div class="controls">
					<input tabindex="2" type="password" class="input span4" placeholder="Password" name="password">
				</div>
			</div>
			<div class="control-group">
				<input tabindex="3" type="submit" class="btn pull-right" value="Sign in">
			</div>
		
		</form>
	</div>
</div>

<?php require 'partials/footer.php'; ?>
