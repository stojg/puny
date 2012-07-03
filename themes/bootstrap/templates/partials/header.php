<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php if(isset($title)){echo $title.' - ';}?>Stig's Journal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    if(isset($posts)) { $post = $posts[0]; }
    if(isset($post)) {
    ?>
    <meta name="description" content="<?php echo $post->getDescription();?>">
    <?php } ?>
    <meta name="author" content="Stig Lindqvist">

    <!-- Le styles -->
    <link href="<?php echo THEME_URL;?>/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo THEME_URL;?>/js/prettify/prettify.css" type="text/css" rel="stylesheet" />
    <link href="<?php echo THEME_URL;?>/css/screen.css" rel="stylesheet">
    
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <!-- Le fav and touch icons -->
    <link href="<?php echo BASE_URL;?>favicon.png" rel="shortcut icon">
  </head>
  <body>
  <div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
      <div class="container">
        <a class="brand" href="<?php echo $app->urlFor('index'); ?>">Stig's journal</a>
        <ul class="nav">
            <li class="active">
              <a href="<?php echo $app->urlFor('index'); ?>">Home</a>
            </li>
            <li>
              <a href="<?php echo $app->urlFor('archives'); ?>">Archives</a>
            </li>
            <?php if($user->valid()) { ?>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                Admin
                <b class="caret"></b>
              </a>
              <ul class="dropdown-menu">
                <li><a href="<?php echo $app->urlFor('edit', array('url'=>$post->basename())); ?>">Edit Page</a></li>
                <li><a href="<?php echo $app->urlFor('add'); ?>">Add Page</a></li>
                <li><a href="<?php echo $app->urlFor('logout'); ?>">Logout</a></li>
              </ul>
            <?php } else { ?>
              <li>
                <a href="<?php echo $app->urlFor('login'); ?>">Sign in</a>
            </li>
            <?php } ?>
          </li>
        </ul>
        <form class="navbar-search pull-right" action="http://google.com/search" method="get">
          <input type="text" class="search-query" placeholder="Search" name="q" results="0">
          <input type="hidden" name="q" value="site:stojg.se/">
        </form>
      </div>
    </div>
  </div>
  <div class="banner">
    <div class="inner">
      <ul class="feed"></ul>
    </div>
  </div>

  <div class="container">