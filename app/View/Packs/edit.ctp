<div class="packs form">
<?php echo $this->Form->create('Pack'); ?>
	<fieldset>
		<legend><?php echo __('パック編集'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('part_id');
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
	<h3><?php echo __('LINK'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('パート一覧'), array('controller' => 'parts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('カード一覧'), array('controller' => 'cards', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('紐付け一覧'), array('controller' => 'links', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('ゴッドリンク一覧'), array('controller' => 'godlinks', 'action' => 'index')); ?> </li>
	</ul>
</div>
