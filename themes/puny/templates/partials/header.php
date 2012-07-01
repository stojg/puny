<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8">
		<title><?php if(isset($title)){echo $title.' - ';}?>Stig's Journal</title>
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
		<link href="<?php echo THEME_URL;?>stylesheets/fb-buttons.css" media="screen, projection" rel="stylesheet" type="text/css">
		<!--[if lt IE 9]><script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	</head>
	<body>
		<header id="header" class="inner">
			<h1>
				<a href="<?php echo $app->urlFor('index'); ?>">Stig's Journal</a>
			</h1>
			<nav class="main-nav">
				<ul class="main">
					<li><a href="<?php echo $app->urlFor('index'); ?>">Blog</a></li>
					<li><a href="<?php echo $app->urlFor('archives'); ?>">Archives</a></li>
				</ul>
			</nav>
			<nav class="mobile-nav">
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
			<nav class="sub-nav alignright">
				<div class="social">
					<a class="google" href="https://plus.google.com/115001706055384421894" title="Google+">Google+</a>
					<a class="twitter" href="http://twitter.com/stojg" title="Twitter">Twitter</a>
				</div>
				<form class="search" action="http://google.com/search" method="get">
					<input class="alignright" type="text" name="q" results="0">
					<input type="hidden" name="q" value="site:stojg.se/">
				</form>
			</nav>
		</header>

		<div class="banner inner">
			<div class="container">
				<ul class="feed"></ul>
			</div>
			<div class="loading">Loading...</div>
		</div>

		<?php if($user->valid()) { ?>
		<div class="actions inner">
			
			<div class="uibutton-group">
				<?php if(isset($post)) { ?>
				<a class="uibutton icon edit right" href="<?php echo $app->urlFor('edit', array('url'=>$post->basename())); ?>">Edit post</a>
				<?php } ?>
				<a class="uibutton icon add" href="<?php echo $app->urlFor('add'); ?>">Add post</a>
			</div>
			
			<div class=" uibutton-group">
				<a class="uibutton " href="<?php echo $app->urlFor('logout'); ?>">Logout</a>
			</div>
		</div>
		<?php } ?>

		<div id="content" class="inner">