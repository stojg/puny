<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8">
		<title>My Journal</title>
		<meta name="author" content="Stig Lindqvist">
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width; initial-scale=1; maximum-scale=1">
		<link rel="canonical" href="">
		<link href="<?php echo BASE_URL;?>favicon.png" rel="shortcut icon">
		<link href="<?php echo THEME_URL;?>stylesheets/screen.css" media="screen, projection" rel="stylesheet" type="text/css">
		<link href="<?php echo THEME_URL;?>stylesheets/font-awesome.css" media="screen, projection" rel="stylesheet" type="text/css">
		<!--[if lt IE 9]><script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
		<script src="<?php echo THEME_URL;?>javascripts/modernizr-2.0.js"></script>
	</head>

	<body>
		<header id="header" class="inner">
			<h1>
				<a href="<?php echo $app->urlFor('index'); ?>">My Journal</a>
			</h1>
			<nav id="main-nav">
				<ul class="main">
					<li><a href="<?php echo $app->urlFor('index'); ?>">Blog</a></li>
					<li><a href="<?php echo $app->urlFor('archives'); ?>">Archives</a></li>
					<?php if($user->valid()) { ?>
					<li><a href="<?php echo $app->urlFor('logout'); ?>">Logout</a></li>
					<?php } else { ?>
					<li><a href="<?php echo $app->urlFor('login'); ?>">Login</a></li>
					<?php }  ?>

				</ul>
			</nav>
			<nav id="mobile-nav">
				<div class="alignleft menu">
					<a class="button">Menu</a>
					<div class="container">
						<ul class="main">
							<li><a href="<?php echo $app->urlFor('index'); ?>">Blog</a></li>
							<li><a href="<?php echo $app->urlFor('archives'); ?>">Archives</a></li>
							<?php if($user->valid()) { ?>
							<li><a href="<?php echo $app->urlFor('logout'); ?>">Logout</a></li>
							<?php } else { ?>
							<li><a href="<?php echo $app->urlFor('login'); ?>">Login</a></li>
							<?php }  ?>
						</ul>
					</div>
				</div>
				<div class="alignright search">
					<a class="button"></a>
					<div class="container">
						<form action="http://google.com/search" method="get">
							<input type="text" name="q" results="0">
							<input type="hidden" name="q" value="site:journal.stojg.se/">
						</form>
					</div>
				</div>
			</nav>
			<nav id="sub-nav" class="alignright">
				<div class="social">
					<a class="google" href="https://plus.google.com/115001706055384421894" title="Google+">Google+</a>
					<a class="twitter" href="http://twitter.com/stojg" title="Twitter">Twitter</a>
					<a class="rss" href="/atom.xml" title="RSS">RSS</a>
				</div>
				<form class="search" action="http://google.com/search" method="get">
					<input class="alignright" type="text" name="q" results="0">
					<input type="hidden" name="q" value="site:journal.stojg.se/">
				</form>
			</nav>
		</header>

		<?php if(!$user->valid()) { ?>
		<div id="banner" class="inner">
			<div class="container">
				<ul class="feed"></ul>
			</div>
			<small><a href="http://twitter.com/stojg">stojg</a> @ <a href="http://twitter.com">Twitter</a></small>
			<div class="loading">Loading...</div>
		</div>
		<?php } ?>

		<div id="content" class="inner">

		<?php if(isset($flash) && $flash) { ?>
			<div class="flashmessage ">
				<?php foreach($flash->getMessages() as $type => $message) { ?>
					<div class="<?php echo $type; ?>"><?php echo $message; ?></div>
				<?php } ?>
			</div>
		<?php } ?>