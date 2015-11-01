<div class="parts form">
<?php echo $this->Form->create('Part'); ?>
	<fieldset>
		<legend><?php echo __('パート編集'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('rank',array('label' => '表示順'));
		echo $this->Form->input('part_name',array('label' => 'パート名'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('更新')); ?>
</div>
<div class="actions">
	<h3><?php echo __('パート'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('パート一覧'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Form->postLink(__('削除'), array('action' => 'delete', $this->Form->value('Part.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Part.id'))); ?></li>
	</ul><br>
	<?php echo $this->element('menu'); ?>
</div>
