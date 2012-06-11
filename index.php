<?php
// Use composer autoloader
require 'vendor/autoload.php';

// HACK to get the Twigview to work
require 'vendor/slim/slim/Slim/View.php';
require 'vendor/slim/extras/Views/TwigView.php';

// Inject which View extension to use
TwigView::$twigExtensions = array(
	'Twig_Extensions_Slim',
);

$app = new Slim(array(
    'view' => 'TwigView'
));

// Indexpage
$app->get('/', function () use($app) {
	$posts = array();
	$files = glob('posts/*.md') ;
	foreach($files as $filename) {
		$posts[] = new \Stojg\Puny\Post($filename);
	}
	$app->render('index.html', array(
		'posts' => $posts,
		'baseURL' => $app->urlFor('index')
	));
})->name('index');

// Single Post
$app->get('/blog/:url', function ($url) use($app) {
	$posts = array();
	$posts[] = new \Stojg\Puny\Post('posts/'.$url.'.md');
	$app->render('index.html', array('posts' => $posts));
})->name('single_post');

$app->get('/archives', function () use($app) {
	$app->render('archives.html');
})->name('archives');

$app->run();