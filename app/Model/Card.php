<?php
App::uses('AppModel', 'Model');
/**
 * Card Model
 *
 * @property Link $Link
 */
class Card extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMeny = array(
		'Link' => array(
			'className' => 'Link',
			'foreignKey' => 'card_id',
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
    public $actsAs = array('Search.Searchable');

	public $filterArgs = array(
		'name' => array('type' => 'query', 'method' => 'orNameConditions'),
		'civilization' => array('type' => 'query', 'method' => 'orCivilizationConditions'),
		//'kind' => array('type' => 'value'),
		'kind' => array('type' => 'query', 'method' => 'orKindConditions'),
		'effects' => array('type' => 'query', 'method' => 'orEffectsConditions'),
		'str' => array('type' => 'query', 'method' => 'orStrConditions'),
	);

	public function orNameConditions( $data = array() ) {
		$filter = $data['name'];
		$cond = array(
			'AND' => array(
				$this->alias . '.name LIKE' => '%' . $filter . '%',
			),
		);
		return $cond;
	}
	
	public function orCivilizationConditions( $data = array() ) {
		$filter = $data['civilization'];
		$cond = array(
			'AND' => array(
				$this->alias . '.civilization LIKE' => '%' . $filter . '%',
			),
		);
		return $cond;
	}
	
	public function orKindConditions( $data = array() ) {
		$filter = $data['kind'];
		$cond = array(
			'AND' => array(
				$this->alias . '.kind = \''.$filter.'\' OR '.$this->alias . '.kind LIKE \''.$filter. ',%'.'\' OR '.$this->alias . '.kind LIKE \'%,' . $filter . ',%\' OR '.$this->alias . '.kind LIKE \''. $filter . ',%\'' => ' ',
				//$this->alias . '.kind LIKE' => '%,' . $filter . ',%',
				//$this->alias . '.kind LIKE' => '%,' . $filter ,
				//$this->alias . '.kind LIKE' =>  $filter . ',%'
			),
			

		);

		return $cond;
	}
	public function orEffectsConditions( $data = array() ) {
		$filter = $data['effects'];
		$cond = array(
			'AND' => array(
				$this->alias . '.effects = \''.$filter.'\' OR '.$this->alias . '.effects LIKE \''.$filter. ',%'.'\' OR '.$this->alias . '.effects LIKE \'%,' . $filter . ',%\' OR '.$this->alias . '.effects LIKE \''. $filter . ',%\'' => ' ',
				//$this->alias . '.effects =' => '%' . $filter . '%',
				//$this->alias . '.effects LIKE' => '%,' . $filter ,
				//$this->alias . '.effects LIKE' =>  $filter . ',%',
				//$this->alias . '.effects LIKE' => '%,' . $filter . ',%',

			),
		);
		return $cond;
	}

	/*
	public function orEffectsConditions( $data = array() ) {
		$filter = $data['effects'];
		$cond = array(
			'OR' => array(
				$this->alias . '.effects =' => '%' . $filter . '%',
				$this->alias . '.effects LIKE' => '%,' . $filter ,
				$this->alias . '.effects LIKE' =>  $filter . ',%',
				$this->alias . '.effects LIKE' => '%,' . $filter . ',%',

			),
		);
		return $cond;
	}
	*/
	public function orStrConditions( $data = array() ) {
		$filter = $data['str'];
		$cond = array(
			'AND' => array(
				$this->alias . '.str LIKE' => '%' . $filter . '%',
			),
		);
		return $cond;
	}
	
	public $validate = array(
		'name' => array(
			array(
				'rule' => 'notEmpty',
				'message' => 'ƒJ[ƒh–¼‚ð“ü—Í‚µ‚Ä‰º‚³‚¢',
			),
		),
	);
	
}
