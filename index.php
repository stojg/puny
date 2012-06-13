<?php
// Set the theme url
if(!defined('THEME_NAME')) {
	define('THEME_NAME', 'puny');
}

// Set constants for this application
require 'constants.inc.php';

// Use composer autoloader
require 'vendor/autoload.php';

session_start();
$app = new Slim(array(
	'templates.path' => 'themes/puny/templates',
));

// Indexpage
$app->get('/', function () use($app) {
	$blog = new stojg\puny\Cached(new stojg\puny\models\Blog('posts/'));
	$app->render('home.php', array(
		'posts' => $blog->getPosts(5),
	));
})->name('index');

// Single Post
$app->get('/blog/:url', function ($url) use($app) {
	$blog = new stojg\puny\Cached(new stojg\puny\models\Blog('posts/'));
	$app->render('single_post.php', array(
		'post' => $blog->getPost($url)
	));
})->name('single_post');

// Archives
$app->get('/archives', function () use($app) {
	$blog = new stojg\puny\Cached(new stojg\puny\models\Blog('posts/'));
	$app->render('archives.php', array(
		'posts' => $blog->getPosts(),
	));
})->name('archives');

// Categories
$app->get('/category/:name', function ($name) use($app) {
	$blog = new stojg\puny\Cached(new stojg\puny\models\Blog('posts/'));
	$app->render('category.php', array(
		'category' => $name,
		'posts' => $blog->getCategory($name),
	));
})->name('category');

/** Admin functionality **/

// Single post Edit
$app->get('/edit/:url', function ($url) use($app) {
	$blog = new stojg\puny\Cached(new stojg\puny\models\Blog('posts/'));
	$app->render('edit.php', array(
		'post' => $blog->getPost($url)
	));
})->name('edit-get');

// Single post Edit
$app->post('/edit/:url', function ($url) use($app) {
	file_put_contents('posts/'.$url.'.md', $app->request()->post('content'));
	$app->flash('info', 'You just saved something');
	$app->redirect($app->request()->getRootUri().'/edit/'.$url);
})->name('edit-post');

$app->run();