<div class="species form">
<?php echo $this->Form->create('Species'); ?>
	<fieldset>
		<legend><?php echo __('Add Species'); ?></legend>
	<?php
		echo $this->Form->input('no', array('default' => $max_id + 1));
		echo $this->Form->input('species_name');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Species'), array('action' => 'index')); ?></li>
	</ul>
</div>
