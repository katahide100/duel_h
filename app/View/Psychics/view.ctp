<div class="psychics view">
<h2><?php  echo __('サイキック管理'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($psychic['Psychic']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('覚醒前'); ?></dt>
		<dd>
			<?php echo h($psychic['Psychic']['psychic_s']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('覚醒後'); ?></dt>
		<dd>
			<?php echo h($psychic['Psychic']['psychic_l']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('サイキック'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('サイキック一覧'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('サイキック編集'), array('action' => 'edit', $psychic['Psychic']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('新規サイキック'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Form->postLink(__('削除'), array('action' => 'delete', $psychic['Psychic']['id']), null, __('Are you sure you want to delete # %s?', $psychic['Psychic']['id'])); ?> </li>
	</ul><br>
	<?php echo $this->element('menu'); ?>
</div>
