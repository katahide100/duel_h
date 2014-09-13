<?php
App::uses('Link', 'Model');

/**
 * Link Test Case
 *
 */
class LinkTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.link',
		'app.pack',
		'app.part',
		'app.card'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Link = ClassRegistry::init('Link');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Link);

		parent::tearDown();
	}

}
