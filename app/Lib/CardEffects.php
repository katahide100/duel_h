<?php
/**
 * cards.effects (効果番号の ',' 区切り文字列) と効果選択フォームの相互変換
 *
 * 既存データには効果一覧に無い値("0" や全角スペースなど)が混ざっているため、
 * 選択式で編集しても一覧に無い値は消さずにそのまま残す。
 */
class CardEffects {

/**
 * 保存値 → 選択済みの効果番号(効果一覧にあるものだけ)
 *
 * @param string $effects 保存値 (例: "1,3,37")
 * @param array $kokaList 効果一覧 (番号 => 名前)
 * @return array
 */
	public static function toSelected($effects, $kokaList) {
		$selected = array();
		foreach (explode(',', (string)$effects) as $token) {
			$no = trim($token);
			if ($no !== '' && isset($kokaList[$no])) {
				$selected[] = $no;
			}
		}
		return $selected;
	}

/**
 * 保存値のうち効果一覧に無い値(フォームでは選べない値)
 *
 * @param string $effects 保存値
 * @param array $kokaList 効果一覧 (番号 => 名前)
 * @return array
 */
	public static function unknownTokens($effects, $kokaList) {
		$unknown = array();
		foreach (explode(',', (string)$effects) as $token) {
			if ($token !== '' && !isset($kokaList[trim($token)])) {
				$unknown[] = $token;
			}
		}
		return $unknown;
	}

/**
 * フォームの選択値 + 元の保存値の一覧外の値 → 保存値
 *
 * @param array|string $selected フォームの選択値 (未選択時は '')
 * @param string $current 更新前の保存値
 * @param array $kokaList 効果一覧 (番号 => 名前)
 * @return string
 */
	public static function merge($selected, $current, $kokaList) {
		$tokens = array();
		foreach ((array)$selected as $no) {
			if ((string)$no !== '' && isset($kokaList[$no])) {
				$tokens[] = (string)$no;
			}
		}
		$tokens = array_merge($tokens, self::unknownTokens($current, $kokaList));
		return implode(',', $tokens);
	}
}
