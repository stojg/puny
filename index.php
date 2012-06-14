<?php
// Set the theme url
if(!defined('THEME_NAME')) {
	define('THEME_NAME', 'puny');
}

// Set constants for this application
require 'constants.inc.php';

// Use composer autoloader
require 'vendor/autoload.php';

session_cache_limiter(false);
session_start();

$app = new Slim(array(
	'templates.path' => 'themes/puny/templates',
));

$locked = function () use($app) {
    return function () use ($app) {
		$user = new \stojg\puny\models\User($app);
		if(!$user->valid()) {
			$app->redirect($app->urlFor('login'));
		}
    };
};

$app->add(new \stojg\puny\helpers\ViewHelper());

// Indexpage
$app->get('/', function () use($app) {
	$blog = new \stojg\puny\Cached(new stojg\puny\models\Blog('posts/'));
	$app->render('home.php', array(
		'posts' => $blog->getPosts(5),
	));
})->name('index');

// Single Post
$app->get('/blog/:url', function ($url) use($app) {
	$blog = new \stojg\puny\Cached(new stojg\puny\models\Blog('posts/'));
	$app->render('single_post.php', array(
		'post' => $blog->getPost($url)
	));
})->name('single_post');

// Archives
$app->get('/archives', function () use($app) {
	$blog = new \stojg\puny\Cached(new stojg\puny\models\Blog('posts/'));
	$app->render('archives.php', array(
		'posts' => $blog->getPosts(),
	));
})->name('archives');

// Categories
$app->get('/category/:name', function ($name) use($app) {
	$blog = new \stojg\puny\Cached(new stojg\puny\models\Blog('posts/'));
	$app->render('category.php', array(
		'category' => $name,
		'posts' => $blog->getCategory($name),
	));
})->name('category');

/** Admin functionality **/

// Single post Edit
$app->get('/edit/:url', $locked(), function ($url) use($app) {
	$blog = new stojg\puny\models\Blog('posts/');
	$app->render('edit.php', array(
		'post' => $blog->getPost($url, false)
	));
})->name('edit');

// Single post Edit
$app->post('/edit/:url', $locked(), function ($url) use($app) {
	$filename = 'posts/'.$url.'.md';
	file_put_contents($filename.'.tmp', $app->request()->post('content'));
	rename($filename.'.tmp', $filename);
	$app->flash('info', 'You just saved something');
	$app->redirect($app->urlFor('edit', array('url'=>$url)));
});

// Login
$app->get('/login/', function() use($app) {
	$app->render('login.php');
})->name('login');

// Login action
$app->post('/login/', function() use($app) {
	$user = new \stojg\puny\models\User();
	if(!$user->login($app)) {
		$app->redirect($app->urlFor('login'));
	}
	$app->redirect($app->urlFor('index'));
});

// Logout
$app->get('/logout', function() use($app) {
	$user = new stojg\puny\models\User();
	$user->logout();
	$app->redirect($app->request()->getRootUri());
})->name('logout');

$app->run();