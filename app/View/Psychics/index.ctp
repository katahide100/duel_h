<div class="psychics index">
	<h2><?php echo __('サイキック一覧'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('覚醒前'); ?></th>
			<th><?php echo $this->Paginator->sort('覚醒後'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($psychics as $psychic): ?>
	<tr>
		<td><?php echo h($psychic['Psychic']['id']); ?>&nbsp;</td>
		<td><?php echo h($psychic['Psychic']['psychic_s']); ?>&nbsp;</td>
		<td><?php echo h($psychic['Psychic']['psychic_l']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('詳細'), array('action' => 'view', $psychic['Psychic']['id'])); ?>
			<?php echo $this->Html->link(__('編集'), array('action' => 'edit', $psychic['Psychic']['id'])); ?>
			<?php echo $this->Form->postLink(__('削除'), array('action' => 'delete', $psychic['Psychic']['id']), null, __('Are you sure you want to delete # %s?', $psychic['Psychic']['id'])); ?>
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
	<h3><?php echo __('サイキック'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('新規サイキック'), array('action' => 'add')); ?></li>
	</ul>
		<h3><?php echo __('LINK'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('パート一覧'), array('controller' => 'parts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('パック一覧'), array('controller' => 'packs', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('カード一覧'), array('controller' => 'cards', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('紐付け一覧'), array('controller' => 'links', 'action' => 'index')); ?> </li>
	</ul>
</div>
