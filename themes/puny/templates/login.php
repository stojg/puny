<?php
	require 'partials/header.php';
?>
	<article class="post">
		<form method="POST">
			<input type="hidden" name="action" value="login" />
			
			<h1 class="title">
				<a href="<?php echo $app->urlFor('login'); ?>">
					Login
				</a>
			</h1>
		<div class="entry-content">
			<div>
				<label for="username">Username:</label>
				<input type="input" name="username" />
			</div>
			<div>
				<label for="password">Password:</label>
				<input type="password" name="password" />
			</div>
			<div>
				<input type="submit" />
			</div>
		</div>
		</form>
	</article>
	<nav id="pagenavi">
		<div class="center"><a href="<? echo $app->urlFor('archives');?>">Blog Archives</a></div>
	</nav>
<?php
	require 'partials/footer.php';
?>