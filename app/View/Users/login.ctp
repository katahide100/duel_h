<div class="users form">
<?php echo $this->Session->flash('auth'); ?>
<?php echo $this->Form->create('User', array('action' => 'login')); ?>
  <fieldset>
    <legend><?php echo __('ログイン名とパスワードを入力して下さい。'); ?></legend>
    <?php 
			echo $this->Form->input('login',array('label'=>'ログイン名'));
      echo $this->Form->input('password',array('label'=>'パスワード'));
    ?>
  </fieldset>
<?php echo $this->Form->end(__('ログイン')); ?>
</div>
