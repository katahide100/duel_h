<div class="packs form">
<?php echo $this->Form->create('Pack'); ?>
	<fieldset>
		<legend><?php echo __('新規パック'); ?></legend>
	<?php
		echo $this->Form->input('part_id');
		echo $this->Form->input('pack_name',array('label' => 'パック名'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('登録')); ?>
</div>
<div class="actions">
	<h3><?php echo __('パック'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('パック一覧'), array('action' => 'index')); ?></li>
	</ul><br>
	<?php echo $this->element('menu'); ?>
</div>
