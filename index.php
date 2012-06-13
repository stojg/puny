<?php
// Set the theme url
if(!defined('THEME_NAME')) {
	define('THEME_NAME', 'puny');
}

// Set constants for this application
require 'constants.inc.php';

// Use composer autoloader
require 'vendor/autoload.php';

$app = new Slim(array(
	'templates.path' => 'themes/puny/templates',
));



// Indexpage
$app->get('/', function () use($app) {
	$blog = new stojg\puny\Cached(new stojg\puny\models\BlogFile('posts/'));
	$app->render('home.php', array(
		'posts' => $blog->getPosts(10),
	));
})->name('index');

// Single Post
$app->get('/blog/:url', function ($url) use($app) {
	$blog = new stojg\puny\Cached(new stojg\puny\models\BlogFile('posts/'));
	$app->render('single_post.php', array(
		'post' => $blog->getPost($url)
	));
})->name('single_post');

// Archives
$app->get('/archives', function () use($app) {
	$blog = new stojg\puny\Cached(new stojg\puny\models\BlogFile('posts/'));
	$app->render('archives.php', array(
		'posts' => $blog->getPosts(10),
	));
})->name('archives');

// Categories
$app->get('/category/:name', function ($name) use($app) {
	$blog = new stojg\puny\Cached(new stojg\puny\models\BlogFile('posts/'));
	$app->render('category.php', array(
		'category' => $name,
		'posts' => $blog->getPosts(10),
	));
})->name('category');

$app->run();