<div class="parts form">
<?php echo $this->Form->create('Part'); ?>
	<fieldset>
		<legend><?php echo __('セーブ'); ?></legend>
	</fieldset>
	<p>このセーブでは、以下の内容がゲームに反映されます。</p>
	<p>・パート</p>
	<p>・パック</p>
	<p>・カード</p>
	<p>・紐付け</p>
	<p>・サイキック</p>
<?php echo $this->Form->end(__('送信')); ?>
</div>
<div class="actions">
	<?php echo $this->element('menu'); ?>
</div>
