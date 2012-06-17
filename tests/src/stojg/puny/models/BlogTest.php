<?php

namespace stojg\puny;

/**
 * Test class for BlogFile.
 * Generated by PHPUnit on 2012-06-11 at 16:29:10.
 */
class BlogTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var BlogFile
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp() {
		$this->object = new models\Blog('tests/src/stojg/puny/models/fixtures/');
	}

	/**
	 * @covers stojg\puny\models\Blog::getPosts
	 */
	public function testGetPosts() {
		$this->assertEquals(6, count($this->object->getPosts()));
		$this->assertEquals(6, count($this->object->getPosts(10)));
		$this->assertEquals(5, count($this->object->getPosts(5)));
	}

	/**
	 *
	 */
	public function testGetPostsIsSorted() {
		$posts = $this->object->getPosts();

		while(count($posts)>2) {
			$first = array_shift($posts);
			$last = array_pop($posts);
			$this->assertGreaterThan($last->getDate('U'),$first->getDate('U'));
		}
	}

	/**
	 * @covers stojg\puny\models\Blog::getPost
	 */
	public function testGetPost() {
		$post = $this->object->getPost('2012-06-09-movie-night');
		$this->assertTrue($post instanceof \stojg\puny\Cached, get_class($post));
		$this->assertEquals('movie night', $post->getTitle());
	}

	/**
	 * @covers stojg\puny\models\Blog::getPost
	 */
	public function testGetPostNoCache() {
		$post = $this->object->getPost('2012-06-09-movie-night', false);
		$this->assertTrue($post instanceof \stojg\puny\models\Post, get_class($post));
		$this->assertEquals('movie night', $post->getTitle());
	}

	/**
	 * @covers stojg\puny\models\Blog::getCacheKey
	 */
	public function testGetCacheKey() {
		$this->assertNotNull($this->object->getCacheKey());
	}

	public function testCategory() {
		$posts = $this->object->getCategory('quiz');
		$this->assertEquals(2, count($posts));
	}
}