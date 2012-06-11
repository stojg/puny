<?php
// Set the theme url
if(!defined('THEME_NAME')) {
	define('THEME_NAME', 'octopress');
}

// Set constants for this application
require 'constants.inc.php';

// Use composer autoloader
require 'vendor/autoload.php';

// HACK to get the Twigview to work
require 'vendor/slim/slim/Slim/View.php';
require 'vendor/slim/extras/Views/TwigView.php';

// Inject which View extension to use
TwigView::$twigExtensions = array('Twig_Extensions_Slim');

$app = new Slim(array(
    'view' => 'TwigView',
	'templates.path' => 'themes/octopress/templates',
));

// Indexpage
$app->get('/', function () use($app) {
	$blog = new Stojg\Puny\BlogFile('posts/');
	$app->render('index.html', array(
		'posts' => $blog->getPosts(10),
		'baseURL' => $app->urlFor('index')
	));
})->name('index');

// Single Post
$app->get('/blog/:url', function ($url) use($app) {
	$blog = new Stojg\Puny\BlogFile('posts/');
	$app->render('single_post.html', array(
		'post' => $blog->getPost($url)
	));
})->name('single_post');

// Archives
$app->get('/archives', function () use($app) {
	$app->render('archives.html');
})->name('archives');

// Categories
$app->get('/category/:name', function ($name) use($app) {
	$app->render('category.html');
})->name('category');

$app->run();