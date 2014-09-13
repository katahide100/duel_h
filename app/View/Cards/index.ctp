
<?php echo $this->Html->script('http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js', array( 'inline' => false ));?>
<?php echo $this->Html->script('jquery.collapse', array( 'inline' => false ));?>



<?php $this->Html->scriptStart(array('inline'=>false)); ?>
//開閉用
function init()
{

document.getElementById("disp").style.display="none";
}
function hyoji1(num)
{
  if (num == 0)
  {
    document.getElementById("disp").style.display="none";
  }
  else
  {
    document.getElementById("disp").style.display="block";
  }
}
window.onload = init;


<?php $this->Html->scriptEnd();?>

<?php $this->Html->scriptStart(array('inline'=>false)); ?>
$(function() {
    $(".demo1").collapse({
		head: "h4",
		group: "div, ul, ol",
		show: function(){
			this.animate({
				opacity: 'toggle', 
				height: 'toggle'
				}, 300);
			},
		hide : function() {
			this.animate({
				opacity: 'toggle', 
				height: 'toggle'
			}, 300);
		}
    });
});
<?php $this->Html->scriptEnd();?>

<div class="cards index">
<table class="nonborder">
<tr><td>
	<h2><?php echo __('カード管理'); ?></h2>
</td><td>
<div class="demo1">
	<div class="righting">
		カード検索画面を
		<h4>表示/非表示</h4>
	
	

<div class="section form_search">
	<h2>検索項目</h2>
	<?php echo $this->Form->create('Card', array( 'novalidate' => true, 'url' => array_merge(array('action' => 'index'), $this->params['pass']) )); ?>
	<h3>カード名</h3>
	<?php echo $this->Form->input('name', array('placeholder' => 'カード名を入力して下さい。', 'label' => false)); ?>
	<h3>文明</h3>
	<?php echo $this->Form->select('civilization', $civilization, array( 'empty' => 'すべて', 'label' => false )); ?>
	<h3>種族</h3>
	<?php echo $this->Form->select('kind', $syuList, array( 'empty' => 'すべて', 'label' => false )); ?>
	<h3>効果</h3>
	<?php echo $this->Form->select('effects', $effects, array( 'empty' => 'すべて', 'label' => false )); ?>
	<h3>能力(文章)</h3>
	<?php echo $this->Form->input('str', array('placeholder' => '能力の一部を入力して下さい。', 'label' => false)); ?>
	<?php echo $this->Form->submit('検索'); ?>
	<?php echo $this->Form->end(); ?>
	</div>
</div>
</div>
</td>
</table>
<div class="section">
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name','カード名'); ?></th>
			<th><?php echo $this->Paginator->sort('civilization','文明'); ?></th>
			<th><?php echo $this->Paginator->sort('kind','種族'); ?></th>
			<th><?php echo $this->Paginator->sort('power','パワー'); ?></th>
			<th><?php echo $this->Paginator->sort('cost','コスト'); ?></th>
			<th><?php echo $this->Paginator->sort('evolution','進化'); ?></th>
			<th><?php echo $this->Paginator->sort('effects','効果'); ?></th>
			<th><?php echo $this->Paginator->sort('trigger','トリガー'); ?></th>
			<th><?php echo $this->Paginator->sort('str','能力'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($cards as $card): ?>
	<tr>
		<td><?php echo h($card['Card']['id']); ?>&nbsp;</td>
		<td><?php echo h($card['Card']['name']); ?>&nbsp;</td>
		<td><?php echo h($card['Card']['civilization']); ?>&nbsp;</td>
		<td><?php echo h($card['Card']['kind']); ?>&nbsp;</td>
		<td><?php echo h($card['Card']['power']); ?>&nbsp;</td>
		<td><?php echo h($card['Card']['cost']); ?>&nbsp;</td>
		<td><?php echo h($card['Card']['evolution']); ?>&nbsp;</td>
		<td><?php echo h($card['Card']['effects']); ?>&nbsp;</td>
		<td><?php echo h($card['Card']['trigger']); ?>&nbsp;</td>
		<td><?php echo h($card['Card']['str']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('詳細'), array('action' => 'view', $card['Card']['id'])); ?>
			<?php echo $this->Html->link(__('編集'), array('action' => 'edit', $card['Card']['id'])); ?>
			<!--<?php echo $this->Form->postLink(__('削除'), array('action' => 'delete', $card['Card']['id']), null, __('Are you sure you want to delete # %s?', $card['Card']['id'])); ?>-->
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	</div><!--section-->
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
	<h3><?php echo __('カード'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('新規カード'), array('action' => 'add')); ?></li>
	</ul><br>
	<h3><?php echo __('LINK'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('パート一覧'), array('controller' => 'parts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('パック一覧'), array('controller' => 'packs', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('紐付け一覧'), array('controller' => 'links', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('ゴッドリンク一覧'), array('controller' => 'godlinks', 'action' => 'index')); ?> </li>
	</ul>
</div>
<?php echo $this->Html->css('card_index', null, array( 'inline' => false )); ?>

