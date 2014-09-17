<div class="parts form">
<?php echo $this->Form->create('Part'); ?>
	<fieldset>
		<legend><?php echo __('新規パート'); ?></legend>
	<?php
		echo $this->Form->input('part_name',array('label' => 'パート名'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('登録')); ?>
</div>
<div class="actions">
	<h3><?php echo __('パート'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('パート一覧'), array('action' => 'index')); ?></li>
	</ul><br>
	<?php echo $this->element('menu'); ?>
</div>
