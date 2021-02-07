<div class="species form">
<?php echo $this->Form->create('Species'); ?>
	<fieldset>
		<legend><?php echo __('Edit Species'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('no');
		echo $this->Form->input('species_name');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Species.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Species.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Species'), array('action' => 'index')); ?></li>
	</ul>
</div>
