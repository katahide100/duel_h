<?php
App::uses('AppModel', 'Model');
App::uses('CsvCondition', 'Lib');
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
		// 他の filterArgs の 'AND' と Set::merge で合成されるよう、数値キーで追加する
		return array('AND' => array(CsvCondition::contains($this->alias . '.kind', $data['kind'])));
	}
	public function orEffectsConditions( $data = array() ) {
		return array('AND' => array(CsvCondition::contains($this->alias . '.effects', $data['effects'])));
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
				'message' => 'カード名を入力して下さい',
			),
		),
	);
	
}
