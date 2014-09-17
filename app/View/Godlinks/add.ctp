<div class="godlinks form">
<?php echo $this->Form->create('Godlink'); ?>
	<fieldset>

<?php
foreach($god as $val){
  $godname[] =  $val['cards']['name'];
}

foreach($god as $val){
  $gods[] =  $val['cards']['id']." : ".$val['cards']['name'];
}

?>
		<legend><?php echo __('新規ゴッドリンク'); ?></legend>
	<?php
		echo $this->Form->input('god_name',array(
      'type' => 'select',
      'options' => $godname,
      'label' => 'リンク元のゴッド'
      ));
		echo $this->Form->input('god_link',array('label' => 'リンクするゴッドのid(すべてのパターン）　※例："1234","1235","1234-1235"','maxlength' => '1000'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('登録')); ?>

  <?php
    echo $this->Form->input('sansyo',array(
      'type' => 'select',
      'options' => $gods,
      'label' => 'id参照'));
  ?>
</div>
<div class="actions">
	<h3><?php echo __('ゴッドリンク'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('ゴッドリンク一覧'), array('action' => 'index')); ?></li>
	</ul><br>
	<?php echo $this->element('menu'); ?>
</div>
