<div class="species view">
<h2><?php  echo __('Species'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($species['Species']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('No'); ?></dt>
		<dd>
			<?php echo h($species['Species']['no']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Species Name'); ?></dt>
		<dd>
			<?php echo h($species['Species']['species_name']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Species'), array('action' => 'edit', $species['Species']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Species'), array('action' => 'delete', $species['Species']['id']), null, __('Are you sure you want to delete # %s?', $species['Species']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Species'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Species'), array('action' => 'add')); ?> </li>
	</ul>
</div>
