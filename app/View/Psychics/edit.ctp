<div class="psychics form">
<?php echo $this->Form->create('Psychic'); ?>
	<fieldset>
		<legend><?php echo __('サイキック編集'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('psychic_s',array('label' => '覚醒前'));
		echo $this->Form->input('psychic_l',array('label' => '覚醒後'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('更新')); ?>
</div>
<div class="actions">
	<h3><?php echo __('サイキック'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('サイキック一覧'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Form->postLink(__('削除'), array('action' => 'delete', $this->Form->value('Psychic.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Psychic.id'))); ?></li>
	</ul><br>
	<?php echo $this->element('menu'); ?>
</div>
