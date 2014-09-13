<?php
App::uses('AppModel', 'Model');
/**
 * Link Model
 *
 * @property Pack $Pack
 * @property Card $Card
 */
class Link extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Pack' => array(
			'className' => 'Pack',
			'foreignKey' => 'pack_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Card' => array(
			'className' => 'Card',
			'foreignKey' => 'card_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
