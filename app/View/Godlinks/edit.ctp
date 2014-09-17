<div class="godlinks form">
<?php echo $this->Form->create('Godlink'); ?>
	<fieldset>
		<legend><?php echo __('ゴッドリンク編集'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('god_name',array('label' => 'リンク元ゴッド'));
		echo $this->Form->input('god_link',array('label' => 'リンクするゴッドid','maxlength' => '1000'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('更新')); ?>
</div>
<div class="actions">
<h3><?php echo __('ゴッドリンク'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('ゴッドリンク一覧'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('新規ゴッドリンク'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Form->postLink(__('ゴッドリンク削除'), array('action' => 'delete', $this->Form->value('Godlink.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Godlink.id'))); ?></li>
	</ul><br>
	<?php echo $this->element('menu'); ?>
</div>
