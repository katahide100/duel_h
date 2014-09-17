<div class="links form">
<?php echo $this->Form->create('Link'); ?>
	<fieldset>
		<legend><?php echo __('紐付け編集'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('pack_id');
		echo $this->Form->input('card_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('更新')); ?>
</div>
<div class="actions">
	<h3><?php echo __('紐付け'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('紐付け一覧'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('新規紐付け'), array('controller' => 'links', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Form->postLink(__('削除'), array('action' => 'delete', $this->Form->value('Link.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Link.id'))); ?></li>
	</ul><br>
	<?php echo $this->element('menu'); ?>
</div>
