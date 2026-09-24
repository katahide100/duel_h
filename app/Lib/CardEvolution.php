<?php
/**
 * cards.evolution (進化種別コード) と進化選択フォームの相互変換
 *
 * evolution は varchar なので、既存データには一覧に無い値が混ざっている
 * ("1,8" のような複合値や、パワーの入力ミスと思われる大きな数値)。
 * プルダウンで編集してもそういう値を壊さないよう、「その他(手入力)」の逃げ道を用意する。
 *
 * 進化種別コードの一覧は CardsController::$evolutionList。
 * duel-next(app/duel/evolution.ts の EVO)と cgi3(duel.pl の evo_norm)にも同じ表がある。
 */
class CardEvolution {

/** 「その他(手入力)」を表すプルダウンの値 */
	const OTHER = '_other';

/**
 * 保存値が進化種別の一覧にあるかどうか
 *
 * @param string $evolution 保存値
 * @param array $evolutionList 進化種別一覧 (コード => 名前)
 * @return bool
 */
	public static function isKnown($evolution, $evolutionList) {
		$value = trim((string)$evolution);
		return $value !== '' && isset($evolutionList[$value]);
	}

/**
 * 保存値 → プルダウンの選択値
 *
 * 一覧にある値はそのまま、空は空、一覧に無い値は「その他(手入力)」を選ばせる。
 *
 * @param string $evolution 保存値
 * @param array $evolutionList 進化種別一覧 (コード => 名前)
 * @return string
 */
	public static function toSelected($evolution, $evolutionList) {
		$value = trim((string)$evolution);
		if ($value === '') {
			return '';
		}
		return self::isKnown($value, $evolutionList) ? $value : self::OTHER;
	}

/**
 * フォームの入力 → 保存値
 *
 * プルダウンが「その他(手入力)」なら手入力欄の値を、そうでなければプルダウンの値を使う。
 * 一覧にも無く手入力も空の場合は、元の保存値を消さずに引き継ぐ
 * (プルダウンを操作していない画面から保存された時に値が消えるのを防ぐ)。
 *
 * @param string $selected プルダウンの値
 * @param string $raw 「その他」の手入力欄の値
 * @param string $current 更新前の保存値
 * @param array $evolutionList 進化種別一覧 (コード => 名前)
 * @return string
 */
	public static function merge($selected, $raw, $current, $evolutionList) {
		$selected = trim((string)$selected);
		$raw = trim((string)$raw);
		if ($selected === self::OTHER) {
			return $raw !== '' ? $raw : trim((string)$current);
		}
		if ($selected === '') {
			return '';
		}
		return self::isKnown($selected, $evolutionList) ? $selected : trim((string)$current);
	}
}
