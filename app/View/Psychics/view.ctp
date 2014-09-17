<div class="psychics view">
<h2><?php  echo __('Psychic'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($psychic['Psychic']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Psychic S'); ?></dt>
		<dd>
			<?php echo h($psychic['Psychic']['psychic_s']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Psychic L'); ?></dt>
		<dd>
			<?php echo h($psychic['Psychic']['psychic_l']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Psychic'), array('action' => 'edit', $psychic['Psychic']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Psychic'), array('action' => 'delete', $psychic['Psychic']['id']), null, __('Are you sure you want to delete # %s?', $psychic['Psychic']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Psychics'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Psychic'), array('action' => 'add')); ?> </li>
	</ul><br>
	<?php echo $this->element('menu'); ?>
</div>
