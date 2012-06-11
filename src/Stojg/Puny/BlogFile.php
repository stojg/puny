<?php

namespace Stojg\Puny;

/**
 * @uses \Stojg\Puny\Post
 */
class BlogFile {

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
		$i = 0;
		$posts = array();
		foreach($this->files as $filename) {
			if($limit && $i>=$limit) {
				return $posts;
			}
			$posts[] = new Cached(new Post($filename));
			$i++;
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
		return new Cached(new Post('posts/'.$name.'.md'));
	}
}