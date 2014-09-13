<div class="cards form">
<?php echo $this->Form->create('Card'); ?>
	<fieldset>
		<legend><?php echo __('カード編集'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name',array('label' => 'カード名'));
		echo $this->Form->input('civilization',array('label' => '文明(数値)'));
		echo $this->Form->input('kind',array('label' => '種族(数値)'));
		echo $this->Form->input('power',array('label' => 'パワー(数値)'));
		echo $this->Form->input('cost',array('label' => 'コスト(数値)'));
		echo $this->Form->input('evolution',array('label' => '進化(数値)'));
		echo $this->Form->input('effects',array('label' => '効果(数値)'));
		echo $this->Form->input('trigger',array('label' => 'トリガー(数値)'));
		echo $this->Form->input('str',array('label' => '能力(文章)'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('更新')); ?>
</div>
<div class="actions">
	<h3><?php echo __('カード'); ?></h3>
	<ul>
		<!--<li><?php echo $this->Form->postLink(__('カード削除'), array('action' => 'delete', $this->Form->value('Card.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Card.id'))); ?></li>-->
		<li><?php echo $this->Html->link(__('カード一覧'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('新規カード'), array('action' => 'add')); ?></li>
	</ul><br>
	<h3><?php echo __('LINK'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('パート一覧'), array('controller' => 'parts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('パック一覧'), array('controller' => 'packs', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('紐付け一覧'), array('controller' => 'links', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('ゴッドリンク一覧'), array('controller' => 'godlinks', 'action' => 'index')); ?> </li>
	</ul>
</div>
