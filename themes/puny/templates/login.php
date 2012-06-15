<?php require 'partials/header.php'; ?>
<article class="post">
	<form method="POST">
		<input type="hidden" name="action" value="login" />
		<h1 class="title">
			<a href="<?php echo $app->urlFor('login'); ?>">Login</a>
		</h1>
		<div class="entry-content">
			<div class="input-prepend field">
				<span class="add-on"><i class="icon-envelope"></i></span>
				<input type="input" name="username" placeholder="Email address" size=40 />
			</div>
			<div class="input-prepend field">
				<span class="add-on"><i class="icon-key"></i></span>
				<input type="password" name="password" placeholder="Password" />
			</div>
			<div class="input-prepend field">
				<span class="add-on"><i class="icon-null"></i></span>
				<input type="submit" class="btn-mini btn-inverse" value="Login" />
			</div>
		</div>
	</form>
</article>
<?php require 'partials/footer.php'; ?>