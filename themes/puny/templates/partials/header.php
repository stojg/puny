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
		<!--[if lt IE 9]><script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	</head>

	<body>
		<header id="header" class="inner">
			<h1>
				<a href="<?php echo Slim::getInstance()->urlFor('index'); ?>">My Journal</a>
			</h1>
			<nav id="main-nav">
				<ul class="main">
					<li><a href="<?php echo Slim::getInstance()->urlFor('index'); ?>">Blog</a></li>
					<li><a href="<?php echo Slim::getInstance()->urlFor('archives'); ?>">Archives</a></li>
				</ul>
			</nav>
			<nav id="mobile-nav">
				<div class="alignleft menu">
					<a class="button">Menu</a>
					<div class="container">
						<ul class="main">
							<li><a href="<?php echo Slim::getInstance()->urlFor('index'); ?>">Blog</a></li>
							<li><a href="<?php echo Slim::getInstance()->urlFor('archives'); ?>">Archives</a></li>
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

		<div id="banner" class="inner">
			<div class="container">
				<ul class="feed"></ul>
			</div>
			<small><a href="http://twitter.com/stojg">stojg</a> @ <a href="http://twitter.com">Twitter</a></small>
			<div class="loading">Loading...</div>
		</div>
		<script src="<?php echo THEME_URL;?>javascripts/twitter.js"></script>
		<script type="text/javascript">
			(function($){
				$('#banner').getTwitterFeed('stojg', 4, false);
			})(jQuery);
		</script>

		<div id="content" class="inner">