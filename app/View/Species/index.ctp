<div class="species index">
	<h2><?php echo __('Species'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<!--<th><?php echo $this->Paginator->sort('id'); ?></th>-->
			<th><?php echo $this->Paginator->sort('no'); ?></th>
			<th><?php echo $this->Paginator->sort('species_name'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($species as $species): ?>
	<tr>
		<!--<td><?php echo h($species['Species']['id']); ?>&nbsp;</td>-->
		<td><?php echo h($species['Species']['no']); ?>&nbsp;</td>
		<td><?php echo h($species['Species']['species_name']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $species['Species']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $species['Species']['id'])); ?>
			<!--<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $species['Species']['id']), null, __('Are you sure you want to delete # %s?', $species['Species']['id'])); ?>-->
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('種属'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('新規種属'), array('action' => 'add')); ?></li>
	</ul><br>
	<?php echo $this->element('menu'); ?>
</div>
