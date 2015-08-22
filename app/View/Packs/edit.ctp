<div class="packs form">
<?php echo $this->Form->create('Pack'); ?>
	<fieldset>
		<legend><?php echo __('パック編集'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('part_id');
		echo $this->Form->input('rank',array('label' => '表示順'));
		echo $this->Form->input('pack_name',array('label' => 'パック名'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('登録')); ?>
</div>
<div class="actions">
	<h3><?php echo __('パック'); ?></h3>
	<ul>
		<!--<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Pack.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Pack.id'))); ?></li>-->
		<li><?php echo $this->Html->link(__('パック一覧'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('新規パック'), array('controller' => 'packs', 'action' => 'add')); ?> </li>
	</ul>
	<?php echo $this->element('menu'); ?>
</div>
