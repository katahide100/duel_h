<div class="godlinks form">
<?php echo $this->Form->create('Godlink'); ?>
	<fieldset>
		<legend><?php echo __('ゴッドリンクセーブ'); ?></legend>
	</fieldset>
<?php echo $this->Form->end(__('送信')); ?>
</div>
<div class="actions">
	<h3><?php echo __('ゴッドリンク'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('ゴッドリンク一覧'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('新規ゴッドリンク'), array('action' => 'add')); ?></li>
	</ul><br>
	<h3><?php echo __('LINK'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('パート一覧'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('パック一覧'), array('controller' => 'packs', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('カード一覧'), array('controller' => 'cards', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('紐付け一覧'), array('controller' => 'links', 'action' => 'index')); ?> </li>
	</ul>
</div>
