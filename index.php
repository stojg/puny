<?php
// Alias the namespace
use \stojg\puny as s;

// get the configuration
require 'config.php';
// Use composer autoloader
require 'vendor/autoload.php';

/**
 * General @todo
 *
 * Add more 404's in the category and archive routes
 * Implement proper application logging
 */

/**
 * Startup the session
 *
 * @todo see if this be skipped so non admin don't have to get 
 * a session
 */
session_cache_limiter(false);
session_start();

/**
 * Get a new shiny Slim application
 * 
 * @var Slim
 */
$app = new Slim(array(
	'templates.path' => TEMPLATE_PATH,
));

/**
 * Add a middleware to all routes.
 * It will add commonly accessed variables to the templates
 */
$app->add(new s\helpers\ViewHelper());

/** 
 * This function can be used as middleware to lock 
 * certain routes.
 */
$locked = function () use($app) {
    return function () use ($app) {
		$user = new s\models\User($app);
		if(!$user->valid()) {
			$app->redirect($app->urlFor('login'));
		}
    };
};

/**
 * This is the index page
 */
$app->get('/', function () use($app) {
	$blog = new s\Cached(new s\models\Blog('posts/'));
	$app->render('home.php', array(
		'posts' => $blog->getPosts(5),
	));
})->name('index');

/**
 * Route for a single post
 * 
 */
$app->get('/blog/:url', function ($url) use($app) {
	$blog = new s\Cached(new s\models\Blog('posts/'));
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

/**
 * A list of all the posts that has been made
 */
$app->get('/archives', function () use($app) {
	$blog = new s\Cached(new s\models\Blog('posts/'));
	$app->render('archives.php', array(
		'posts' => $blog->getPosts(),
		'title' => 'Archives',
	));
})->name('archives');

/**
 * Show all posts tagged with a category
 */
$app->get('/category/:name', function ($name) use($app) {
	$blog = new s\Cached(new s\models\Blog('posts/'));
	$app->render('category.php', array(
		'category' => $name,
		'posts' => $blog->getCategory($name),
		'title' => $name,
	));
})->name('category');

/** 
 * Display a form for adding a new post
 */
$app->get('/add', $locked(), function() use($app) {
	$post = new s\models\Post('posts/');
	$app->render('edit.php', array(
		'post' => $post,
		'title' => 'New post'
	));
})->name('add');

/**
 * Add a new post to the datastore
 * @todo Move the set and save out of the route 
 */
$app->post('/add', $locked(), function() use($app) {
	$req = $app->request();
	$post = new s\models\Post('posts/');
	$post->setContent($req->post('content'))
		->setTitle($req->post('title'))
		->setDate($req->post('date'))
		->setCategories($req->post('categories'))
		->save('posts');
	$app->flash('info', 'You just create a new post.');
	$app->redirect($app->urlFor('edit', array('url'=>$post->basename())));
});

/**
 * Display the form for editing a post
 */
$app->get('/edit/:url', $locked(), function ($url) use($app) {
	$blog = new s\models\Blog('posts/');
	$app->render('edit.php', array(
		'post' => $blog->getPost($url, false)
	));
})->name('edit');

/**
 * Save a currently edited post
 * @todo Move the set and save out of the route
 */
$app->post('/edit/:url', $locked(), function ($url) use($app) {
	$req = $app->request();
	$blog = new s\models\Blog('posts/');
	$post = $blog->getPost($url, false);
	$post->setContent($req->post('content'))
		->setTitle($req->post('title'))
		->setDate($req->post('date'))
		->setCategories($req->post('categories'))
		->save('posts');
	$app->flash('info', 'Post have been saved');
	$app->redirect($app->urlFor('edit', array('url'=>$post->basename())));
});

/**
 * Display the login form
 */
$app->get('/login/', function() use($app) {
	$app->render('login.php');
})->name('login');

/**
 * Check the login information
 * 
 * @todo move the login method out of the User model
 */
$app->post('/login/', function() use($app) {
	$user = new s\models\User();
	if(!$user->login($app)) {
		$app->flash('error', 'Login failed!');
		$app->redirect($app->urlFor('login'));
	}
	$app->redirect($app->urlFor('index'));
});

/**
 * Logout the user
 *
 * @todo move the logout method out of the User model
 */
$app->get('/logout', function() use($app) {
	$user = new s\models\User();
	$user->logout();
	$app->redirect($app->request()->getRootUri());
})->name('logout');

/**
 * The 404 not found route
 */
$app->notFound(function () use ($app) {
    $app->render('404.php');
});

/**
 * Finally, run the app!
 */
$app->run();