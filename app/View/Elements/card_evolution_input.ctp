<?php
App::uses('CardEvolution', 'Lib');
/**
 * 進化欄（プルダウン + 「その他(手入力)」）
 *
 * evolution は varchar で、既存データに一覧化できない値（"1,8" のような複合値など）が
 * 入っているため、プルダウンだけにすると編集・保存でその値が壊れる。
 * 「その他(手入力)」を選んだ時だけ手入力欄を出して、元の値をそのまま保存できるようにする。
 * 手入力欄の表示切り替えは webroot/js/tagselect.js。
 *
 * @var string $id 同じ画面に複数のフォームがあるため、手入力欄と紐付けるための識別子
 * @var array $evolutions 進化種別一覧（CardsController::$evolutionList）
 * @var string $evolutionRaw 一覧に無い保存値（無ければ空）
 */
$id = isset($id) ? $id : 'evolution';
$evolutionRaw = isset($evolutionRaw) ? $evolutionRaw : '';
$options = $evolutions;
$options[CardEvolution::OTHER] = 'その他（手入力）';
?>
<div class="input select">
	<label for="CardEvolution<?php echo h($id); ?>">進化</label>
	<?php
	echo $this->Form->select('evolution', $options, array(
		'empty' => '進化しない',
		'label' => false,
		'id' => 'CardEvolution' . $id,
		'data-evolution-select' => $id,
		'data-evolution-other' => CardEvolution::OTHER,
	));
	?>
</div>
<div class="input text" data-evolution-raw="<?php echo h($id); ?>" style="display:none;">
	<label for="CardEvolutionRaw<?php echo h($id); ?>">進化（手入力）</label>
	<?php
	echo $this->Form->text('evolution_raw', array(
		'id' => 'CardEvolutionRaw' . $id,
		'value' => $evolutionRaw,
	));
	?>
	<p>一覧に無い値をそのまま保存する場合だけ入力する（空なら元の値のまま）。</p>
</div>
