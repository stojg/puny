<?php

namespace Stojg\Puny;

/**
 * @uses \Stojg\Puny\Post
 */
class BlogFile extends Blog {

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

	/**
	 * The directory of all posts
	 *
	 * @param string $directory
	 */
	public function __construct($directory) {
		$this->directory = $directory;
		$this->files = glob($this->directory.DIRECTORY_SEPARATOR.'*.md');
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
			$posts[] = new \Stojg\Puny\Post($filename);
			$i++;
		}
		return $posts;
	}

	/**
	 * Returns one single post
	 * @param string $name
	 * @return \Stojg\Puny\Post
	 */
	public function getPost($name) {
		return new \Stojg\Puny\Post('posts/'.$name.'.md');
	}
}