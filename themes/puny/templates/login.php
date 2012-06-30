<?php require 'partials/header.php'; ?>
<article class="post">
	<form method="POST">
		<input type="hidden" name="action" value="login" />
		<h1 class="title">
			<a href="<?php echo $app->urlFor('login'); ?>">Login</a>
		</h1>
		<?php if(isset($flash) && $flash) { ?>
		<div class="flashmessage ">
			<?php foreach($flash->getMessages() as $type => $message) { ?>
				<div class="<?php echo $type; ?>"><?php echo $message; ?></div>
			<?php } ?>
		</div>
		<?php } ?>
		<div class="entry-content">
			<div class="field">
				<label for="username">Username</label>
				<input type="text" id="username" name="username" placeholder="Email address" size=40 />
			</div>
			<div class="field">
				<label for="password">Password</label>
				<input type="password" id="password" name="password" placeholder="Password" />
			</div>
			<div class="field">
				<input type="submit" class="" value="Login" />
			</div>
		</div>
	</form>
</article>
<?php require 'partials/footer.php'; ?>