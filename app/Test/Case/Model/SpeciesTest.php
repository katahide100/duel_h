<?php
App::uses('Species', 'Model');

/**
 * Species Test Case
 *
 */
class SpeciesTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.species'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Species = ClassRegistry::init('Species');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Species);

		parent::tearDown();
	}

}
