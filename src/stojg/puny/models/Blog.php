<?php

namespace stojg\puny\models;

/**
 * Represents a Blog with a bunch of posts. This is in practice a directory with
 * markdown files in it.
 *
 * @uses Post
 * @uses \stojg\puny\Cached
 */
class Blog {

	/**
	 * The directory where the posts are located
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
	 * An unique ID for this blog
	 * 
	 * @var string
	 */
	protected $id = null;

	/**
	 * The directory of all posts
	 *
	 * @param string $directory
	 */
	public function __construct($directory) {
		$this->directory = $directory;
		$this->files = glob($this->directory . DIRECTORY_SEPARATOR . '*' . Post::extension());
		rsort($this->files);
	}

	/**
	 * Get this blogs unique identifier (sha1)
	 *
	 * @return string
	 */
	public function getID() {
		if(!$this->id) {
			foreach($this->files as $file) {
				$this->id = sha1($this->id.sha1_file($file));
			}
		}
		return $this->id;
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
	 * Get a list of a blog posts that matches the category name
	 *
	 * @param string $categoryName
	 * @return array
	 */
	public function getCategory($categoryName) {
		$posts = array();
		foreach($this->files as $filename) {
			$post = new \stojg\puny\Cached(new Post($filename));
			if(in_array($categoryName, $post->getCategories())) {
				$posts[] = $post;
			}
		}
		return $posts;
	}

	/**
	 * Returns one single post
	 * 
	 * @param string $name
	 * @return \stojg\puny\models\Post|\stojg\puny\Cached
	 */
	public function getPost($name, $cached=true) {
		if(!$cached) {
			return new Post($this->directory.$name.Post::extension());
		}
		return new \stojg\puny\Cached(new Post($this->directory.$name.Post::extension()));
	}
}