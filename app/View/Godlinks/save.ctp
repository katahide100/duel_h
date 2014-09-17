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
	<?php echo $this->element('menu'); ?>
</div>
