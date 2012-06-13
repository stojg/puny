<?php

namespace stojg\puny\models;

/**
 * @uses \Stojg\Puny\Post
 */
class Blog {

	/**
	 *
	 * @var string
	 */
	protected $directory = null;

	/**
	 *
	 * @var array
	 */
	protected $files = array();

	protected $cacheKey = '';

	/**
	 * The directory of all posts
	 *
	 * @param string $directory
	 */
	public function __construct($directory) {
		$this->directory = $directory;
		$this->files = glob($this->directory.DIRECTORY_SEPARATOR.'*.md');
		rsort($this->files);
		foreach($this->files as $file) {
			$this->cacheKey = md5($this->cacheKey.md5_file($file));
		}
	}

	public function getCacheKey() {
		return $this->cacheKey;
	}

	/**
	 * Returns an array of \Stojg\Puny\Post
	 *
	 * @param int $limit - if false return all
	 * @return array|\Stojg\Puny\Post
	 */
	public function getPosts($limit=false) {
		$posts = array();
		$i = 0;
		foreach($this->files as $filename) {
			if($limit && $i>=$limit) {
				return $posts;
			}
			$posts[] = new \stojg\puny\Cached(new Post($filename));
			$i++;
		}
		return $posts;
	}

	/**
	 *
	 * @param string $name
	 * @return \stojg\puny\Cached
	 */
	public function getCategory($name) {
		$posts = array();
		foreach($this->files as $filename) {
			$post = new \stojg\puny\Cached(new Post($filename));
			if(in_array($name, $post->getCategories())) {
				$posts[] = $post;
			}
		}
		return $posts;
	}

	/**
	 * Returns one single post
	 * 
	 * @param string $name
	 * @return \Stojg\Puny\Post
	 */
	public function getPost($name) {
		return new \stojg\puny\Cached(new Post($this->directory.$name.'.md'));
	}
}