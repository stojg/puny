<?php

class PostTest extends PHPUnit_Framework_TestCase {

	/**
	 *
	 * @var \Stojg\Puny\Post
	 */
	protected $object = null;

	public function setUp() {
		$this->object = new \Stojg\Puny\Post('tests/Stojg/Puny/fixtures/2012-06-07-quiz-night.md');
	}

	public function testInit() {
		$this->assertTrue($this->object instanceof \Stojg\Puny\Post);
	}

	public function testGetDate() {
		$this->assertEquals('2012-06-07 17:42:00', $this->object->getDate());
	}
}
