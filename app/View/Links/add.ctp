<div class="links form">
<?php echo $this->Form->create('Link'); ?>
	<fieldset>
		<legend><?php echo __('新規紐付け'); ?></legend>
	<?php
		echo $this->Form->input('pack_id');
		echo $this->Form->input('card_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('登録')); ?>
</div>
<div class="actions">
	<h3><?php echo __('紐付け'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('紐付け一覧'), array('action' => 'index')); ?></li>
	</ul><br>
	<?php echo $this->element('menu'); ?>
</div>
