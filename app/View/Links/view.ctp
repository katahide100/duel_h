<div class="links view">
<h2><?php  echo __('紐付け管理'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($link['Link']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('パック'); ?></dt>
		<dd>
			<?php echo $this->Html->link($link['Pack']['id'], array('controller' => 'packs', 'action' => 'view', $link['Pack']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('カード'); ?></dt>
		<dd>
			<?php echo $this->Html->link($link['Card']['name'], array('controller' => 'cards', 'action' => 'view', $link['Card']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('紐付け'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('紐付け一覧'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('紐付け編集'), array('action' => 'edit', $link['Link']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('新規紐付け'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Form->postLink(__('紐付け削除'), array('action' => 'delete', $link['Link']['id']), null, __('Are you sure you want to delete # %s?', $link['Link']['id'])); ?> </li>
	</ul><br>
	<?php echo $this->element('menu'); ?>
</div>
