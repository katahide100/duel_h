<div class="packs index">
	<h2><?php echo __('パック管理'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('part_name','パート名'); ?></th>
			<th><?php echo $this->Paginator->sort('pack_name','パック名'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($packs as $pack): ?>
	<tr>
		<td><?php echo h($pack['Pack']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($pack['Part']['part_name'], array('controller' => 'parts', 'action' => 'view', $pack['Part']['part_name'])); ?>
		</td>
		<td><?php echo h($pack['Pack']['pack_name']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('詳細'), array('action' => 'view', $pack['Pack']['id'])); ?>
			<?php echo $this->Html->link(__('編集'), array('action' => 'edit', $pack['Pack']['id'])); ?>
			<?php echo $this->Form->postLink(__('削除'), array('action' => 'delete', $pack['Pack']['id']), null, __('Are you sure you want to delete # %s?', $pack['Pack']['id'])); ?>
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
	<h3><?php echo __('パック'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('新規パック'), array('action' => 'add')); ?></li>
	</ul><br>
	<h3><?php echo __('LINK'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('パート一覧'), array('controller' => 'parts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('カード一覧'), array('controller' => 'cards', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('紐付け一覧'), array('controller' => 'links', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('ゴッドリンク一覧'), array('controller' => 'godlinks', 'action' => 'index')); ?> </li>
	    <li><?php echo $this->Html->link(__('サイキック一覧'), array('controller' => 'psychics', 'action' => 'index')); ?> </li>
	    <li><?php echo $this->Html->link(__('セーブ'), array('action' => 'save')); ?></li>
	</ul>
</div>