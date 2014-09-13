<?php
App::uses('AppModel', 'Model');
/**
 * Part Model
 *
 * @property Pack $Pack
 */
class Part extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Pack' => array(
			'className' => 'Pack',
			'foreignKey' => 'part_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
