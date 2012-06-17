# Intro

A puny little PHP blog platform that aims to be as small and fast as possible.

It does not rely on any database modules, but relies on a stock PHP installation.

If APC is installed it will use it for caching to avoid unnecessary disk I/O.

# Installation

First we have to install some dependencies from [packagist.org](http://packagist.org/), see that
page for more information about the packagist and composer.

This project relies on the following packagist packages:

 - dflydev's [PHP Markdown & Extra](https://github.com/dflydev/dflydev-markdown) fork
 - codeguy's [Slim](http://slimframework.com) framework

First you have to Download the composer.phar into the project root

	curl -s http://getcomposer.org/installer | php

Then install the dependencies:

	php composer.phar install

# Build status

This project is using the awesome travis ci for continues unit testing.

[![Build Status](https://secure.travis-ci.org/stojg/puny.png?branch=master)](http://travis-ci.org/stojg/puny)