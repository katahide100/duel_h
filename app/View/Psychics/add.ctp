<head>
<?php echo $this->Html->script('http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js', array( 'inline' => false ));?>
<?php echo $this->Html->script('http://html5shiv.googlecode.com/svn/trunk/html5.js', array( 'inline' => false ));?>
<?php echo $this->Html->script('jquerytabchangecontents', array( 'inline' => false ));?>
<?php echo $this->Html->css('card_index', null, array( 'inline' => false )); ?>
<?php echo $this->Html->css('demo', null, array( 'inline' => false )); ?>
<?php echo $this->Html->script('googleanalytics', array( 'inline' => false ));?>

<style>
ul#tabchange {
	width: 500px;
	*zoom: 1; /*forIE6,7*/
}
ul#tabchange:after {
	content: "";
	display: block;
	clear: both;
}
ul#tabchange li {
	width: 100px;
	float: left;
	text-align: center;
}
ul#tabchange li a {
	display: block;
	/* background-color: #666; */
	background-color: #f9f9f9;
	/* border-right: 1px solid #333;
	border-left: 1px solid #999; */
	border-right: 1px solid #d3d3d3;
	border-left: 1px solid #ffffff;
	padding: 10px;
	color: #3a2d4e;
	text-decoration: none;
}
ul#tabchange li a:hover {
	background-color: #999;
	border-right: 1px solid #666;
	border-left: 1px solid #ccc;
}
ul#tabchange li a.activeBox {
	/* background-color: #333; */
	background-color: #d3d3d3;
	/* border-right: 1px solid #000;
	border-left: 1px solid #333; */
	border-right: 1px solid #adadad;
	border-left: 1px solid #f9f9f9;
	cursor: default;
}
ul#tabchange li a.activeBox:hover {
	/* background-color: #333;
	border-right: 1px solid #000;
	border-left: 1px solid #333; */
	background-color: #d3d3d3;
	border-right: 1px solid #adadad;
	border-left: 1px solid #f9f9f9;
}
div#tabchangeContents {
	width: 500px;
}
div#tabchangeContents div.tabchangeBox {
	width: 480px;
	/* background-color: #333333; */
	background-color: #d3d3d3;
	padding: 10px;
}
div#tabchangeContents div.tabchangeBox p {
	color: #fff;
}
div#tabchangeContents div.tabchangeBox p.sample {
	*zoom: 1;
}
div#tabchangeContents div.tabchangeBox p.sample:after {
	content: "";
	display: block;
	clear: both;
}
div#tabchangeContents div.tabchangeBox p.sample1 img {
	margin-right: 10px;
	float: left;
}
div#tabchangeContents div.tabchangeBox p.sample2 img {
	margin-left: 10px;
	float: right;
}
</style>

</head>
<div class="psychics form">

覚醒種類選択：
<section id="contents">
		<ul id="tabchange">
<li><a href="#box1">覚醒</a></li>
<li><a href="#box2">覚醒リンク</a></li>

</ul>


<div id="tabchangeContents">
<div id="box1" class="tabchangeBox">

<?php echo $this->Form->create('Psychic'); ?>
	<fieldset>
		<legend><?php echo __('新規サイキック'); ?></legend>
	<?php
		
		echo $this->Form->input('psychic_s',array(
        'type' => 'select',
        'options' => $psychicname,
        'label' => '覚醒前クリーチャー(コスト小)'
        ));	
        echo $this->Form->input('psychic_l',array(
        'type' => 'select',
        'options' => $psychicname,
        'label' => '覚醒後クリーチャー(コスト大)'
        ));
      
		//echo $this->Form->input('psychic_s');
		//echo $this->Form->input('psychic_l');
	?>
	</fieldset>
<?php echo $this->Form->end(__('登録')); ?>
</div>

<div id="box2" class="tabchangeBox">

<?php echo $this->Form->create('Psychic'); ?>
	<fieldset>
		<legend><?php echo __('新規サイキック'); ?></legend>
	<?php
		echo '<label for="PsychicName">覚醒前([ctrl]ボタンを押しながら複数選択可)</label>'.$this->Form->select('psychic_s', $psychicname, array( 'empty' => '以下より選択', 'label' => false, 'multiple' => true, 'size' =>
		 10)).'<br><br>';

	    echo $this->Form->input('psychic_sp',array(
        'type' => 'select',
        'options' => $psychic_spname,
        'label' => 'サイキック・スーパー・クリーチャー'
        ));
	
		//echo $this->Form->input('psychic_s');
		//echo $this->Form->input('psychic_l');
	?>
	</fieldset>
<?php echo $this->Form->end(__('登録')); ?>
</div>
</div>
</section>

</div>

<div class="actions">
	<h3><?php echo __('サイキック'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('サイキック一覧'), array('action' => 'index')); ?></li>
	</ul><br>
	<?php echo $this->element('menu'); ?>
</div>
