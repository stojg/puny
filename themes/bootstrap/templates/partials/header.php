<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php if(isset($title)){echo $title.' - ';}?>Stig's Journal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    if(isset($posts) && is_array($posts) && count($posts)) { $post = $posts[0]; }
    if(isset($post) && $post->getDescription()) {
    ?>
    <meta name="description" content="<?php echo $post->getDescription();?>">
    <?php } ?>
    <meta name="author" content="Stig Lindqvist">

    <!-- Le styles -->
    <link href="<?php echo THEME_URL;?>/css/bootstrap.css" rel="stylesheet">
	<link href="<?php echo THEME_URL;?>/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="<?php echo THEME_URL;?>/css/screen.css" rel="stylesheet">

    <link rel="stylesheet" href="//yandex.st/highlightjs/7.0/styles/default.min.css">
    
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <!-- Le fav and touch icons -->
    <link href="<?php echo BASE_URL;?>favicon.png" rel="shortcut icon">
  </head>
  <body>
  <div class="navbar">
    <div class="navbar-inner">
      <div class="container">
        <a class="brand" href="<?php echo $app->urlFor('index'); ?>">Stig's journal</a>
        <ul class="nav">
            <li>
              <a href="<?php echo $app->urlFor('index'); ?>">Home</a>
            </li>
            <li>
              <a href="<?php echo $app->urlFor('archives'); ?>">Archives</a>
            </li>
            <?php if($user->valid()) { ?>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Admin<b class="caret"></b></a>
              <ul class="dropdown-menu">
                <?php if(isset($post)) { ?>
                <li><a href="<?php echo $app->urlFor('edit', array('url'=>$post->basename())); ?>">Edit Page</a></li>
                <?php } ?>
                <li><a href="<?php echo $app->urlFor('add'); ?>">Add Page</a></li>
                <li><a href="<?php echo $app->urlFor('instagram'); ?>">Instagram</a></li>
                <li class="divider"></li>
                <li><a href="<?php echo $app->urlFor('logout'); ?>">Logout</a></li>
              </ul>
            <?php } else { ?>
              <li>
                <a href="<?php echo $app->urlFor('login'); ?>">Sign in</a>
            </li>
            <?php } ?>
          </li>
        </ul>
        <form class="pull-right navbar-search" action="//google.com/search" method="get">
          <input type="text" class="" placeholder="Search" name="q" results="0">
          <input type="hidden" name="q" value="site:stojg.se/">
        </form>
      </div>
    </div>
  </div>

  <div class="container-fluid">
