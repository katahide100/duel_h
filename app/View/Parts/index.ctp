<div class="parts index">
	<h2><?php echo __('パート管理'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('rank','表示順'); ?></th>
			<th><?php echo $this->Paginator->sort('part_name','パート名'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($parts as $part): ?>
	<tr>
		<td><?php echo h($part['Part']['id']); ?>&nbsp;</td>
		<td><?php echo h($part['Part']['rank']); ?>&nbsp;</td>
		<td><?php echo h($part['Part']['part_name']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('詳細'), array('action' => 'view', $part['Part']['id'])); ?>
			<?php echo $this->Html->link(__('編集'), array('action' => 'edit', $part['Part']['id'])); ?>
			<?php echo $this->Form->postLink(__('削除'), array('action' => 'delete', $part['Part']['id']), null, __('Are you sure you want to delete # %s?', $part['Part']['id'])); ?>
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
	<h3><?php echo __('パート'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('新規パート'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('セーブ'), array('action' => 'save')); ?></li>
	</ul><br>
	<?php echo $this->element('menu'); ?>
</div>
