<?php
// get the configuration
require 'config.php';
// Use composer autoloader
require 'vendor/autoload.php';

session_cache_limiter(false);
session_start();

$app = new Slim(array(
	'templates.path' => TEMPLATE_PATH,
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
	$post = $blog->getPost($url);
	if(!$post->exists()) {
		$app->notFound();
		return;
	};
	
	$app->render('single_post.php', array(
		'post' => $post,
		'title' => $post->getTitle(),
	));
})->name('single_post');

// Archives
$app->get('/archives', function () use($app) {
	$blog = new \stojg\puny\Cached(new stojg\puny\models\Blog('posts/'));
	$app->render('archives.php', array(
		'posts' => $blog->getPosts(),
		'title' => 'Archives',
	));
})->name('archives');

// Categories
$app->get('/category/:name', function ($name) use($app) {
	$blog = new \stojg\puny\Cached(new stojg\puny\models\Blog('posts/'));
	$app->render('category.php', array(
		'category' => $name,
		'posts' => $blog->getCategory($name),
		'title' => $name,
	));
})->name('category');

/** Admin functionality **/

$app->get('/add', $locked(), function() use($app) {
	$post = new stojg\puny\models\Post('posts/');
	$app->render('edit.php', array(
		'post' => $post,
		'title' => 'New post'
	));
})->name('add');

$app->post('/add', $locked(), function() use($app) {
	$req = $app->request();
	$post = new stojg\puny\models\Post('posts/');
	$post->setContent($req->post('content'))
		->setTitle($req->post('title'))
		->setDate($req->post('date'))
		->setCategories($req->post('categories'))
		->save('posts');
	$app->flash('info', 'You just create a new post.');
	$app->redirect($app->urlFor('edit', array('url'=>$post->basename())));
});

// Single post Edit
$app->get('/edit/:url', $locked(), function ($url) use($app) {
	$blog = new stojg\puny\models\Blog('posts/');
	$app->render('edit.php', array(
		'post' => $blog->getPost($url, false)
	));
})->name('edit');

// Single post Edit
$app->post('/edit/:url', $locked(), function ($url) use($app) {
	$req = $app->request();
	$blog = new stojg\puny\models\Blog('posts/');
	$post = $blog->getPost($url, false);
	$post->setContent($req->post('content'))
		->setTitle($req->post('title'))
		->setDate($req->post('date'))
		->setCategories($req->post('categories'))
		->save('posts');
	$app->flash('info', 'Post have been saved');
	$app->redirect($app->urlFor('edit', array('url'=>$post->basename())));
});

// Login
$app->get('/login/', function() use($app) {
	$app->render('login.php');
})->name('login');

// Login action
$app->post('/login/', function() use($app) {
	$user = new \stojg\puny\models\User();
	if(!$user->login($app)) {
		$app->flash('error', 'Login failed, try again!');
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

$app->notFound(function () use ($app) {
    $app->render('404.php');
});

$app->run();