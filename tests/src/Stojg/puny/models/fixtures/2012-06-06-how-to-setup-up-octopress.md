---
layout: post
title: "How to setup up Octopress"
date: 2012-06-06 16:17
comments: true
categories: [install,webdev]
---

This is a condensed setup summary from [octopress.org](http://octopress.org/docs/setup/) that includes setting up rbenv for managing ruby version.

I'm using Google drive to sync this journal between computers and as a backup. I could do it with git as well, but I thought that this would take one thing out of the equation.

Note that these instructions are for OSX, so there might be some problems with other *nix systems.

## Setting up rbenv

source: [github.com/sstephenson/rbenv](https://github.com/sstephenson/rbenv)

rbenv is like rvm, but I don't really like rvm, so I'm trying out rbenv instead (rbenv and rvm is basically ruby version manager)

	cd
	git clone git://github.com/sstephenson/rbenv.git .rbenv
	echo 'export PATH="$HOME/.rbenv/bin:$PATH"' >> ~/.bash_profile
	echo 'eval "$(rbenv init -)"' >> ~/.bash_profile
	exec $SHELL

###  rbenv-install plugin

The rbenv-install plugin automates the task of downloading and installing a ruby version.

	mkdir -p ~/.rbenv/plugins
	cd ~/.rbenv/plugins
	git clone git://github.com/sstephenson/ruby-build.git

Install a ruby version

	rbenv install 1.9.2-p320
    rbenv local 1.9.2-p320

## Install octopress in google drive

	cd ~/Google\ Drive/
	git clone git://github.com/imathis/octopress.git octopress
	cd octopress
	ruby --version  # Should report Ruby 1.9.2

	gem install bundler
	rbenv rehash
	bundle install

	rake install