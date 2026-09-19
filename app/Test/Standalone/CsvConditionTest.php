<?php
/**
 * CsvCondition の回帰テスト (PHPUnit 不要)
 *
 * 実行: docker compose exec web php app/Test/Standalone/CsvConditionTest.php
 *
 * 経緯: カード一覧の効果/種族検索の条件で "X,%" を 2 回書いていて "%,X" (末尾) が抜けていた。
 * EXライフ追加パッチで effects の末尾に ",37" を足したところ、効果「EXライフ」で検索しても
 * 1 件も出なかった。末尾に番号があるカードが必ず検索に出ることをここで固定する。
 */
require dirname(dirname(dirname(__FILE__))) . '/Lib/CsvCondition.php';

// CakePHP の条件配列を、1 つの値に対して SQL と同じ意味で評価する (= と LIKE のみ対応)
function matchesCondition($cond, $value) {
	foreach ($cond['OR'] as $clause) {
		foreach ($clause as $key => $pattern) {
			if (substr($key, -5) === ' LIKE') {
				$regex = '';
				foreach (preg_split('/(\\\\.|%|_)/', $pattern, -1, PREG_SPLIT_DELIM_CAPTURE) as $part) {
					if ($part === '%') {
						$regex .= '.*';
					} elseif ($part === '_') {
						$regex .= '.';
					} elseif (strlen($part) === 2 && $part[0] === '\\') {
						$regex .= preg_quote($part[1], '/');
					} else {
						$regex .= preg_quote($part, '/');
					}
				}
				if (preg_match('/^' . $regex . '$/s', $value)) {
					return true;
				}
			} elseif ($pattern === $value) {
				return true;
			}
		}
	}
	return false;
}

$failures = 0;
function check($label, $actual, $expected) {
	global $failures;
	if ($actual === $expected) {
		echo "ok   $label\n";
	} else {
		$failures++;
		echo "FAIL $label (expected " . var_export($expected, true) . ", got " . var_export($actual, true) . ")\n";
	}
}

$cond = CsvCondition::contains('Card.effects', '37');

check('単独 "37" にヒット', matchesCondition($cond, '37'), true);
check('先頭 "37,1" にヒット', matchesCondition($cond, '37,1'), true);
check('途中 "1,37,2" にヒット', matchesCondition($cond, '1,37,2'), true);
// 今回のバグ: パッチで末尾に足した ",37" が検索に出なかった
check('末尾 "3,12,28,37" にヒット', matchesCondition($cond, '3,12,28,37'), true);

check('"3" にはヒットしない', matchesCondition($cond, '3'), false);
check('"137" (部分一致) にはヒットしない', matchesCondition($cond, '137'), false);
check('"1,371" (部分一致) にはヒットしない', matchesCondition($cond, '1,371'), false);
check('"373,1" (部分一致) にはヒットしない', matchesCondition($cond, '373,1'), false);
check('空文字にはヒットしない', matchesCondition($cond, ''), false);

// 種族 (kind) も同じ条件を使う
$kind = CsvCondition::contains('Card.kind', '195');
check('種族: 末尾 "12,195" にヒット', matchesCondition($kind, '12,195'), true);
check('種族: "1195" にはヒットしない', matchesCondition($kind, '1195'), false);

// LIKE のワイルドカードは値の中でエスケープされる
check('"%" は "1,37" にヒットしない', matchesCondition(CsvCondition::contains('Card.effects', '%'), '1,37'), false);

echo $failures ? "\n$failures failed\n" : "\nall passed\n";
exit($failures ? 1 : 0);
