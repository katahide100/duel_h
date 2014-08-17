<div class="godlinks view">
<h2><?php  echo __('ゴッドリンク管理'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($godlink['Godlink']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('リンク元ゴッド'); ?></dt>
		<dd>
			<?php echo h($godlink['Godlink']['god_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('リンクするゴッドid'); ?></dt>
		<dd>
			<?php echo h($godlink['Godlink']['god_link']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('ゴッドリンク'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('ゴッドリンク一覧'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('ゴッドリンク編集'), array('action' => 'edit', $godlink['Godlink']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('新規ゴッドリンク'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Form->postLink(__('ゴッドリンク削除'), array('action' => 'delete', $godlink['Godlink']['id']), null, __('Are you sure you want to delete # %s?', $godlink['Godlink']['id'])); ?> </li>
	</ul><br>
	<h3><?php echo __('LINK'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('パート一覧'), array('controller' => 'parts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('パック一覧'), array('controller' => 'packs', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('カード覧'), array('controller' => 'cards', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('紐付け一覧'), array('controller' => 'links', 'action' => 'index')); ?> </li>
	</ul>
</div>
