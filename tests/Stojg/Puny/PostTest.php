<?php

class PostTest extends PHPUnit_Framework_TestCase {

	public function testInit() {
		$obj = new \Stojg\Puny\Post('test');
		$this->assertTrue($obj instanceof \Stojg\Puny\Post);
	}
}
