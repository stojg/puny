<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8">
		<title><?php if(isset($title)){echo $title.' - ';}?>My Journal</title>
		<meta name="author" content="Stig Lindqvist">
		<?php
		if(isset($posts)) { $post = $posts[0]; }
		if(isset($post)) { ?>
		<meta name="description" content="<?php echo $post->getDescription();?>">
		<?php } ?>
		<meta name="viewport" content="width=device-width; initial-scale=1; maximum-scale=1">
		<link rel="canonical" href="">
		<link href="<?php echo BASE_URL;?>favicon.png" rel="shortcut icon">
		<link href="<?php echo THEME_URL;?>stylesheets/screen.css" media="screen, projection" rel="stylesheet" type="text/css">
		<link href="<?php echo THEME_URL;?>stylesheets/form.css" media="screen, projection" rel="stylesheet" type="text/css">
		<link href="<?php echo THEME_URL;?>stylesheets/font-awesome.css" media="screen, projection" rel="stylesheet" type="text/css">
		<!--[if lt IE 9]><script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
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
				</ul>
			</nav>
			<nav id="mobile-nav">
				<div class="alignleft menu">
					<a class="button">Menu</a>
					<div class="container">
						<ul class="main">
							<li><a href="<?php echo $app->urlFor('index'); ?>">Blog</a></li>
							<li><a href="<?php echo $app->urlFor('archives'); ?>">Archives</a></li>
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
				</div>
				<form class="search" action="http://google.com/search" method="get">
					<input class="alignright" type="text" name="q" results="0">
					<input type="hidden" name="q" value="site:journal.stojg.se/">
				</form>
			</nav>
		</header>

		<div id="banner" class="inner">
			<div class="container">
				<ul class="feed"></ul>
			</div>
			
			<div class="loading">Loading...</div>
		</div>
		<div id="content" class="inner">