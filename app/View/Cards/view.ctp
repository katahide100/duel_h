<div class="cards view">
<h2><?php  echo __('カード管理'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($card['Card']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('カード名'); ?></dt>
		<dd>
			<?php echo h($card['Card']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('文明'); ?></dt>
		<dd>
			<?php echo h($card['Card']['civilization']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('種族'); ?></dt>
		<dd>
			<?php echo h($card['Card']['kind']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('パワー'); ?></dt>
		<dd>
			<?php echo h($card['Card']['power']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('コスト'); ?></dt>
		<dd>
			<?php echo h($card['Card']['cost']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('進化'); ?></dt>
		<dd>
			<?php echo h($card['Card']['evolution']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('効果'); ?></dt>
		<dd>
			<?php echo h($card['Card']['effects']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('トリガー'); ?></dt>
		<dd>
			<?php echo h($card['Card']['trigger']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('能力'); ?></dt>
		<dd>
			<?php echo h($card['Card']['str']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('カード'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('カード一覧'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('カード編集'), array('action' => 'edit', $card['Card']['id'])); ?> </li>
		<!--<li><?php echo $this->Form->postLink(__('カード削除'), array('action' => 'delete', $card['Card']['id']), null, __('Are you sure you want to delete # %s?', $card['Card']['id'])); ?> </li>-->
		<li><?php echo $this->Html->link(__('新規カード'), array('action' => 'add')); ?> </li>
	</ul><br>
	<h3><?php echo __('LINK'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('パート一覧'), array('controller' => 'parts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('パック一覧'), array('controller' => 'packs', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('紐付け一覧'), array('controller' => 'links', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('ゴッドリンク一覧'), array('controller' => 'godlinks', 'action' => 'index')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('このカードの紐付け'); ?></h3>
	<?php if (!empty($card['Link'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Pack Id'); ?></th>
		<th><?php echo __('Card Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($card['Link'] as $link):?>
		
		<tr>
			<td><?php echo $link['id']; ?></td>
			<td><?php echo $link['pack_id']; ?></td>
			<td><?php echo $link['card_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('詳細'), array('controller' => 'links', 'action' => 'view', $link['id'])); ?>
				<?php echo $this->Html->link(__('編集'), array('controller' => 'links', 'action' => 'edit', $link['id'])); ?>
				<!--<?php echo $this->Form->postLink(__('削除'), array('controller' => 'links', 'action' => 'delete', $link['id']), null, __('Are you sure you want to delete # %s?', $link['id'])); ?>-->
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('新規紐付け'), array('controller' => 'links', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
