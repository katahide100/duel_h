<?php
App::uses('AppModel', 'Model');
/**
 * Psychic Model
 *
 */
class Psychic extends AppModel {
    public $belongsTo = array(
		'CardS' => array(
			'className' => 'Card',
			'foreignKey' => 'psychic_s',
			'conditions' => '',
			'fields' => '',
			'order' => ''
        ),
        'CardL' => array(
			'className' => 'Card',
			'foreignKey' => 'psychic_l',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
