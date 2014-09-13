<div class="parts view">
<h2><?php  echo __('パート管理'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($part['Part']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('パート名'); ?></dt>
		<dd>
			<?php echo h($part['Part']['part_name']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('パート'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('パート一覧'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('パート編集'), array('action' => 'edit', $part['Part']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('新規パート'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Form->postLink(__('パート削除'), array('action' => 'delete', $part['Part']['id']), null, __('Are you sure you want to delete # %s?', $part['Part']['id'])); ?> </li>
	</ul><br>
	<h3><?php echo __('LINK'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('パック一覧'), array('controller' => 'packs', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('カード一覧'), array('controller' => 'cards', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('紐付け一覧'), array('controller' => 'links', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('ゴッドリンク一覧'), array('controller' => 'godlinks', 'action' => 'index')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('このパートに含まれるパック'); ?></h3>
	<?php if (!empty($part['Pack'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Part Id'); ?></th>
		<th><?php echo __('パック名'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($part['Pack'] as $pack): ?>
		<tr>
			<td><?php echo $pack['id']; ?></td>
			<td><?php echo $pack['part_id']; ?></td>
			<td><?php echo $pack['pack_name']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('詳細'), array('controller' => 'packs', 'action' => 'view', $pack['id'])); ?>
				<?php echo $this->Html->link(__('編集'), array('controller' => 'packs', 'action' => 'edit', $pack['id'])); ?>
				<?php echo $this->Form->postLink(__('削除'), array('controller' => 'packs', 'action' => 'delete', $pack['id']), null, __('Are you sure you want to delete # %s?', $pack['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('新規パック'), array('controller' => 'packs', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
