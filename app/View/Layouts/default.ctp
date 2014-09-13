<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('cake.generic');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
	<script language="JavaScript">
		<!--

		//Open Subwindow (http://duel.wktk.so/chat/chat.php)

		function WinOpen(color,x,y,msg){
			var Win1=window.open('http://duel.wktk.so/card_chat/chat.php','Subwin','toolbar=no,location=no,resizable=1,width='+x+',height='+y+'');
			if(navigator.appVersion.charAt(0)>=3){Win1.focus()};
			//Win1.document.clear();
			//Win1.document.write("<html><title>Sub Window</title>");
			//Win1.document.write("<body bgcolor="+color+">");
			//Win1.document.write(msg);
			//Win1.document.write("<p align=center><form><input type=button value='閉じる' onClick='window.close()'></form></p>");
			//Win1.document.write("</body></html>");
			//Win1.document.close();
			}
		//-->
	</script>
	<STYLE Type="text/css">
<!--

.chatbtn{
height:0px;
width:110px;
margin-left: auto;s
}

.sample1{
font-size:10pt;
}

.headtbl{
width: 250px;
font-size:large;
}

-->
</STYLE>
</head>
<body>
	<div id="container">
	
		<div id="header">

			<h1>
				<?php //echo $this->Html->link($cakeDescription, 'http://cakephp.org'); ?>
       			<?php echo $this->Html->link(__('ログアウト'),
         		array(
           		'controller' => 'users',
           		'action'     => 'logout'
         		), array('escape'=>false)); ?>
 			</h1>

            
		</div>
		
		<div id="content">
 			<div class="chatbtn">
 				<form name="form1" > 
                <input type="button" value="作成者用チャット" onClick="WinOpen('#000000','400','500','<p><font size=2 color=#FFFFFF>ボタン毎に簡単な説明文を表示できます。</font></p>')" class="sample1"> 
            	</form><br>
            	            <?php
$names = array();
foreach (file('../../../card_chat/data/sessions.dat.cgi') as $line) {
	list(,, $name) = split("\t", rtrim($line));
	array_push($names, $name);
}
echo '<p>参加者(' . count($names) . '):</p>';
if (count($names)) {
	echo '<ul>';
	foreach ($names as $name)
		echo "<li>$name</li>";
	echo '</ul>';
} else {
	echo '<p>なし</p>';
}
?> 
            </div>

			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>
			


		</div>
		
		<div id="footer">
			<?php echo $this->Html->link(
				$this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')),
				'http://www.cakephp.org/',
				array('target' => '_blank', 'escape' => false)
				);
			?>
		</div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
