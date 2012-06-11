<?php

namespace Stojg\Puny;

/**
 * Test class for Post.
 * Generated by PHPUnit on 2012-06-11 at 16:01:14.
 */
class PostTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var Post
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp() {
		$this->object = new Post('tests/Stojg/Puny/fixtures/2012-06-07-quiz-night.md');
	}

	/**
	 * @covers Stojg\Puny\Post::__construct
	 */
	public function testInit() {
		$this->assertTrue($this->object instanceof \Stojg\Puny\Post);
	}

	/**
	 * @covers Stojg\Puny\Post::toHTML
	 * @covers Stojg\Puny\Post::setMetadata
	 */
	public function testToHTML() {
		// Remove the following lines when you implement this test.
		$expected = "<p>It's that time in the week when 'A foreign affair' goes to the quiz-night at the Grands. We usually ends up at the bottom half in the results. This might be the result of the lack of knowledge we have in things not categorized in either technology, movies or music.</p>

<p>Sometimes we've been lucky enough to hit the second to last place, that given us a whopping $20 bar tab. Split that money on 4-5 people and we can almost get half a beer each.</p>

<p>Usually it's three europeans and one kiwi, but tonight we're getting some help from the french nation.</p>
";
		$this->assertEquals($expected, $this->object->toHTML());
	}

	/**
	 * @covers Stojg\Puny\Post::getTitle
	 * @covers Stojg\Puny\Post::setMetadata
	 */
	public function testGetTitle() {
		$expected = 'Quiz night';
		$this->assertEquals($expected, $this->object->getTitle());
	}

	/**
	 * @covers Stojg\Puny\Post::getDate
	 * @covers Stojg\Puny\Post::setMetadata
	 */
	public function testGetDate() {
		$this->assertEquals('2012-06-07 17:42:00', $this->object->getDate());
	}

	/**
	 * @covers Stojg\Puny\Post::getCategories
	 * @covers Stojg\Puny\Post::setMetadata
	 */
	public function testGetCategories() {
		$expected = array(
			0 => 'quiz',
			1 => 'bar'
		);
		$this->assertEquals($expected, $this->object->getCategories());
	}

	/**
	 * @covers Stojg\Puny\Post::getURL
	 * @covers Stojg\Puny\Post::setMetadata
	 */
	public function testGetURL() {
		$expected = '2012-06-07-quiz-night';
		$this->assertEquals($expected, $this->object->getURL());
	}

	/**
	 * @covers Stojg\Puny\Post::getContent
	 * @covers Stojg\Puny\Post::setMetadata
	 */
	public function testGetContent() {
		$expected = "It's that time in the week when 'A foreign affair' goes to the quiz-night at the Grands. We usually ends up at the bottom half in the results. This might be the result of the lack of knowledge we have in things not categorized in either technology, movies or music.

Sometimes we've been lucky enough to hit the second to last place, that given us a whopping $20 bar tab. Split that money on 4-5 people and we can almost get half a beer each.

Usually it's three europeans and one kiwi, but tonight we're getting some help from the french nation.";
		$this->assertEquals($expected, $this->object->getContent());
	}

}

?>
