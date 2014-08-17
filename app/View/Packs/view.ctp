<div class="packs view">
<h2><?php  echo __('パック詳細'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($pack['Pack']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('所属パート'); ?></dt>
		<dd>
			<?php echo $this->Html->link($pack['Part']['part_name'], array('controller' => 'parts', 'action' => 'view', $pack['Part']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('パック名'); ?></dt>
		<dd>
			<?php echo h($pack['Pack']['pack_name']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('パック'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('パック一覧'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('パック編集'), array('action' => 'edit', $pack['Pack']['id'])); ?> </li>
		<!--<li><?php echo $this->Form->postLink(__('パック削除'), array('action' => 'delete', $pack['Pack']['id']), null, __('Are you sure you want to delete # %s?', $pack['Pack']['id'])); ?> </li>-->
		<li><?php echo $this->Html->link(__('新規パック'), array('action' => 'add')); ?> </li>
	</ul><br>
	<h3><?php echo __('LINK'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('パート一覧'), array('controller' => 'parts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('カード一覧'), array('controller' => 'cards', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('紐付け一覧'), array('controller' => 'links', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('ゴッドリンク一覧'), array('controller' => 'godlinks', 'action' => 'index')); ?> </li>
	</ul>

</div>
<div class="related">
	<h3><?php echo __('このパックに含まれるカード'); ?></h3>
	<?php if (!empty($pack['Link'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('パック名'); ?></th>
		<th><?php echo __('カード名'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($link as $linking): ?>
		<tr>
			<td><?php echo $linking['Link']['id']; ?></td>
			<td><?php echo $linking['Pack']['pack_name']; ?></td>
			<td><?php echo $linking['Card']['name']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('詳細'), array('controller' => 'links', 'action' => 'view', $linking['Link']['id'])); ?>
				<?php echo $this->Html->link(__('編集'), array('controller' => 'links', 'action' => 'edit', $linking['Link']['id'])); ?>
				<?php echo $this->Form->postLink(__('削除'), array('controller' => 'links', 'action' => 'delete', $linking['Link']['id']), null, __('Are you sure you want to delete # %s?', $linking['Link']['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('新規リンク'), array('controller' => 'links', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
