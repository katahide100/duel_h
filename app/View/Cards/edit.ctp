<head>
<?php echo $this->Html->css('tagselect', null, array( 'inline' => false )); ?>
<?php echo $this->Html->script('tagselect', array( 'inline' => false ));?>
</head>

<div class="cards form">
<?php echo $this->Form->create('Card'); ?>
	<fieldset>
		<legend><?php echo __('カード編集'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name',array('label' => 'カード名'));
		echo $this->Form->input('civilization',array('label' => '文明(数値)'));
		echo $this->Form->input('kind',array('label' => '種族(数値)'));
		echo $this->Form->input('power',array('label' => 'パワー(数値)'));
		echo $this->Form->input('cost',array('label' => 'コスト(数値)'));
		echo $this->element('card_evolution_input', array(
			'id' => 'Edit',
			'evolutions' => $evolutions,
			'evolutionRaw' => $evolutionRaw,
		));
		// 複数選択はタグ(バッジ)入力にする（webroot/js/tagselect.js）。
		// JS が無効でも元の複数選択セレクトとして動く
		echo '<label for="CardEffects">効果（クリックで追加）</label>'.$this->Form->select('effects', $kokas, array( 'label' => false, 'multiple' => true, 'data-tagselect' => 'true'));
		if ($unknownEffects) {
			// 一覧に無い効果値はフォームで選べないが、保存時に CardEffects::merge が引き継ぐ
			echo '<p>一覧に無い効果値（そのまま保存されます）: ';
			foreach ($unknownEffects as $unknownEffect) {
				echo '<span class="tagselect-fixed">'.h($unknownEffect).'</span>';
			}
			echo '</p>';
		}
		echo $this->Form->input('trigger',array('label' => 'トリガー(数値)'));
		echo $this->Form->input('str',array('label' => '能力(文章)'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('更新')); ?>
</div>
<div class="actions">
	<h3><?php echo __('カード'); ?></h3>
	<ul>
		<!--<li><?php echo $this->Form->postLink(__('カード削除'), array('action' => 'delete', $this->Form->value('Card.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Card.id'))); ?></li>-->
		<li><?php echo $this->Html->link(__('カード一覧'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('新規カード'), array('action' => 'add')); ?></li>
	</ul><br>
	<?php echo $this->element('menu'); ?>
</div>
