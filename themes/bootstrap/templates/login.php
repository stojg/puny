<?php require 'partials/header.php'; ?>
<div class="row">
    <div class="span10 offset2">
    	
		<form class="well form-horizontal" method="post">
			<fieldset>
				<legend>Login form</legend>
			<input type="hidden" name="action" value="login" />
			<?php if(isset($flash) && $flash) { ?>
			<div class="flashmessage">
				<?php foreach($flash->getMessages() as $type => $message) { ?>
					<div class="<?php echo $type; ?>"><?php echo $message; ?></div>
				<?php } ?>
			</div>
			<?php } ?>
			<div class="control-group">
				<label class="control-label" for="username">Username</label>
				<div class="controls">
					<input type="text" class="input" placeholder="Username" id="username" name="username">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="password">Password</label>
				<div class="controls">
					<input type="password" class="input" placeholder="Password" name="password">
				</div>
			</div>
			<div class="control-group">
				<input type="submit" class="btn btn-primary" value="Sign in">
			</div>
		</fieldset>
		</form>
	</div>
</div>

<?php require 'partials/footer.php'; ?>