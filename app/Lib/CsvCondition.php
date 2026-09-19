<?php
/**
 * ',' 区切りの番号列 (cards.effects / cards.kind) に指定番号を含むかの検索条件
 *
 * 以前は Card::orEffectsConditions / orKindConditions で "X,%" を 2 回書いていて
 * "%,X" (末尾) が抜けていたため、末尾に番号があるカードが検索に出なかった。
 * (EXライフ追加パッチで ",37" を末尾に足したカードが 1 件も出なかった)
 */
class CsvCondition {

/**
 * @param string $field カラム名 (例: "Card.effects")
 * @param string $value 番号 (例: "37")
 * @return array CakePHP の検索条件
 */
	public static function contains($field, $value) {
		$like = addcslashes((string)$value, '%_\\');
		return array('OR' => array(
			array($field => (string)$value), // 単独   "37"
			array($field . ' LIKE' => $like . ',%'), // 先頭   "37,1"
			array($field . ' LIKE' => '%,' . $like . ',%'), // 途中   "1,37,2"
			array($field . ' LIKE' => '%,' . $like), // 末尾   "1,37"
		));
	}
}
