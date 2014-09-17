<div class="links index">
	<h2><?php echo __('紐付け管理'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('pack_id'); ?></th>
			<th><?php echo $this->Paginator->sort('card_id'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($links as $link): ?>
	<tr>
		<td><?php echo h($link['Link']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($link['Pack']['id'], array('controller' => 'packs', 'action' => 'view', $link['Pack']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($link['Card']['name'], array('controller' => 'cards', 'action' => 'view', $link['Card']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('詳細'), array('action' => 'view', $link['Link']['id'])); ?>
			<?php echo $this->Html->link(__('編集'), array('action' => 'edit', $link['Link']['id'])); ?>
			<?php echo $this->Form->postLink(__('削除'), array('action' => 'delete', $link['Link']['id']), null, __('Are you sure you want to delete # %s?', $link['Link']['id'])); ?>
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
	<h3><?php echo __('紐付け'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('新規紐付け'), array('action' => 'add')); ?></li>
	</ul><br>
	<?php echo $this->element('menu'); ?>
</div>
