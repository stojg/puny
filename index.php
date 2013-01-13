<?php
// alias the namespace
use \stojg\puny as puny;

// get the configuration
require 'config.php';
// use composer autoloader
require 'vendor/autoload.php';

puny\Puny::start_session(7200);

/**
 * Get a new shiny Slim application
 * 
 * @var Slim
 */
$app = new Slim(array(
	'templates.path' => TEMPLATE_PATH,
));

/**
 * Add a middleware to all routes. Adding commonly accessed variables to the
 * view.
 */
$app->add(new puny\helpers\ViewHelper());

/** 
 * This is a Slim middleware route that prevents non logged in visitors to
 * access that route
 */
$locked = function () use($app) {
    return function () use ($app) {
		if(!puny\User::is_logged_in()) {
			$app->redirect($app->urlFor('login'));
		}
    };
};

/**
 * This is the index page
 */
$app->get('/', function () use($app) {
	$posts = puny\Blog::get_posts(5);
	$app->render('home.php', array('posts' => $posts));
})->name('index');

/**
 * Show a single post
 */
$app->get('/blog/:url', function ($url) use($app) {
	$blog = new puny\Blog('posts/');
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
	$app->render('archives.php', array(
		'posts' => puny\Blog::get_posts(false),
		'title' => 'Archives',
	));
})->name('archives');

/**
 * Show all posts tagged with a category
 */
$app->get('/category/:name', function ($name) use($app) {
	$blog = new puny\Blog('posts/');
	$app->render('category.php', array(
		'category' => $name,
		'posts' => $blog->getCategory($name, null, puny\User::is_logged_in($app)),
		'title' => $name,
	));
})->name('category');

/** 
 * Display a form for adding a new post
 */
$app->get('/add', $locked(), function() use($app) {
	$post = new puny\Post('posts/');
	$app->render('edit.php', array(
		'post' => $post,
		'title' => 'New post'
	));
})->name('add');

/**
 * Add a new post to the datastore
 */
$app->post('/add', $locked(), function() use($app) {
	$post = new puny\Post('posts/');
	puny\Post::save_post($app->request(), $post);
	$app->flash('info', 'You just create a new post.');
	$app->redirect($app->urlFor('edit', array('url' => $post->basename())));
});

/**
 * Display the form for editing a post
 */
$app->get('/edit/:url', $locked(), function ($url) use($app) {
	$blog = new puny\Blog('posts/');
	$app->render('edit.php', array('post' => $blog->getPost($url, false)));
})->name('edit');

/**
 * Save a currently edited post
 */
$app->post('/edit/:url', $locked(), function ($url) use($app) {
	$blog = new puny\Blog('posts/');
	$post = $blog->getPost($url, false);
	puny\Post::save_post($app->request(), $post);
	$app->flash('info', 'Post have been saved');
	$app->redirect($app->urlFor('edit', array('url'=>$post->basename())));
});

/**
 * Display images from my instagram so that I can post them
 */
$app->get('/instagram/', $locked(), function() use($app) {
	$instagram = new puny\api\Instagram(INSTAGRAM_CLIENT_ID, INSTAGRAM_CLIENT_SECRET);
	if(!$instagram->isLoggedIn()) {
		return $app->redirect($app->urlFor('instagram_auth'));
	}
	$media = $instagram->getRecentMedia();
	$app->render('instagram.php', array('images' => $media['data']));
})->name('instagram');

/**
 * Do the oAuth login with instagram
 */
$app->get('/instagram/auth/', $locked(), function () use($app) {
	$callback = puny\Puny::protocol_and_host().$app->urlFor('instagram_auth');
	$instagram = new puny\api\Instagram(INSTAGRAM_CLIENT_ID, INSTAGRAM_CLIENT_SECRET);
	// No code, authorize the app and get a code
	if(!$app->request()->params('code')) {
		return $app->redirect($instagram->getAuthURL($callback));
	}
	// get access token
	$instagram->login($app->request()->params('code'), $callback);
	// go back to the instagram page
 	$app->redirect($app->urlFor('instagram'));
})->name('instagram_auth');

/**
 * Display images from my facebook so that I can post them
 */
$app->get('/facebook/', $locked(), function() use($app) {
	$facebook = new puny\api\Facebook(FACEBOOK_CLIENT_ID, FACEBOOK_CLIENT_SECRET);
	if(!$facebook->isLoggedIn()) {
		return $app->redirect($app->urlFor('facebook_auth'));
	}
	$media = $facebook->getRecentMedia();
	$app->render('facebook.php', array('images' => $media['data']));
})->name('facebook');

/**
 * Do the oAuth login with facebook
 */
$app->get('/facebook/auth/', $locked(), function () use($app) {
	$callback = puny\Puny::protocol_and_host().$app->urlFor('facebook_auth');
	$faceboook = new puny\api\Facebook(FACEBOOK_CLIENT_ID, FACEBOOK_CLIENT_SECRET);
	// No code, authorize the app and get a code
	if(!$app->request()->params('code')) {
		return $app->redirect($faceboook->getAuthURL($callback));
	}
	// get access token
	$faceboook->login($app->request()->params('code'), $callback);
	// go back to the instagram page
 	$app->redirect($app->urlFor('facebook'));
})->name('facebook_auth');


$app->get('/download', $locked(), function() use($app) {
	if(!is_dir('assets')) { mkdir('assets/thumbs', 0775, true); }
	$link = $app->request()->get('link');
	copy($link , './assets/'.basename($link));
	$app->redirect($app->urlFor('files'));
})->name('download');

$app->get('/files',  $locked(), function() use($app) {
	$files = array();
	foreach(glob('./assets/*') as $file) {
		if(!is_file($file)) { continue; }
		$files[] = new puny\File($file);
	}
	$app->render('files.php', array('files'=>$files));
})->name('files');

/**
 * Display the login form
 */
$app->get('/login/', function() use($app) {
	$app->render('login.php');
})->name('login');

/**
 * Login the user
 */
$app->post('/login/', function() use($app) {
	$user = new puny\User();
	if(!$user->login($app)) {
		$app->flash('error', 'Login failed!');
		$app->redirect($app->urlFor('login'));
	}
	$app->redirect($app->urlFor('index'));
});

/**
 * Logout the user
 */
$app->get('/logout', function() use($app) {
	$user = new puny\User();
	$user->logout();
	$app->redirect($app->request()->getRootUri());
})->name('logout');

/**
 * The 404 - Not found route
 * 
 */
$app->notFound(function () use ($app) {
    $app->render('404.php');
});

/**
 * Finally, run the app!
 */
$app->run();