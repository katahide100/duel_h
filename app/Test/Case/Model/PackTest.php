<?php
App::uses('Pack', 'Model');

/**
 * Pack Test Case
 *
 */
class PackTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.pack',
		'app.part',
		'app.link'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Pack = ClassRegistry::init('Pack');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Pack);

		parent::tearDown();
	}

}
