<?php

// Load the autoloader from composer 
if (!@include __DIR__ . '/../vendor/.composer/autoload.php') {
    die(
		'You must set up the project dependencies, run the following commands:'.PHP_EOL.
		'wget http://getcomposer.org/composer.phar'.PHP_EOL.
		'php composer.phar install'
    );
}
