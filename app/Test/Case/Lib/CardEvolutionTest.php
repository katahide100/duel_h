<?php
App::uses('CardEvolution', 'Lib');

/**
 * CardEvolution Test Case
 */
class CardEvolutionTest extends CakeTestCase {

	public $evolutionList = array(
		'1' => '通常進化',
		'8' => 'マナ進化',
		'11' => '墓地進化',
		'14' => 'NEO進化',
		'15' => 'G-NEO進化',
	);

	public function testIsKnown() {
		$this->assertTrue(CardEvolution::isKnown('1', $this->evolutionList));
		$this->assertTrue(CardEvolution::isKnown('15', $this->evolutionList));
		$this->assertTrue(CardEvolution::isKnown(' 14 ', $this->evolutionList));
		$this->assertFalse(CardEvolution::isKnown('', $this->evolutionList));
		$this->assertFalse(CardEvolution::isKnown(null, $this->evolutionList));
		// 一覧に無い値(複合値・入力ミス)
		$this->assertFalse(CardEvolution::isKnown('1,8', $this->evolutionList));
		$this->assertFalse(CardEvolution::isKnown('3500', $this->evolutionList));
	}

	public function testToSelected() {
		$this->assertSame('', CardEvolution::toSelected('', $this->evolutionList));
		$this->assertSame('', CardEvolution::toSelected(null, $this->evolutionList));
		$this->assertSame('14', CardEvolution::toSelected('14', $this->evolutionList));
		// 一覧に無い値は「その他(手入力)」を選ばせる
		$this->assertSame(CardEvolution::OTHER, CardEvolution::toSelected('1,8', $this->evolutionList));
		$this->assertSame(CardEvolution::OTHER, CardEvolution::toSelected('3500', $this->evolutionList));
	}

	public function testMergeSelectedFromList() {
		$this->assertSame('15', CardEvolution::merge('15', '', '1', $this->evolutionList));
		// 進化なしに戻せる
		$this->assertSame('', CardEvolution::merge('', '', '15', $this->evolutionList));
	}

	public function testMergeOther() {
		// 「その他」+ 手入力 → 手入力値を保存する
		$this->assertSame('1,8', CardEvolution::merge(CardEvolution::OTHER, '1,8', '1,8', $this->evolutionList));
		// 「その他」で手入力が空なら元の値を引き継ぐ(値を消さない)
		$this->assertSame('3500', CardEvolution::merge(CardEvolution::OTHER, '', '3500', $this->evolutionList));
	}

	public function testMergeUnknownSelectedKeepsCurrent() {
		// プルダウンに無い値が送られてきた場合は元の値を維持する
		$this->assertSame('1,8', CardEvolution::merge('99', '', '1,8', $this->evolutionList));
	}
}
