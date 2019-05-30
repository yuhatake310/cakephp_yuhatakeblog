<?php $this->assign('title', 'ログイン画面'); ?>
<div class="users form">
<?php echo $this->Flash->render('auth'); ?>
<?php echo $this->Form->create('User'); ?>
<fieldset>
<legend>
<?php echo __('ユーザー名とパスワードを入力してください'); ?>
</legend>
<?php
echo $this->Form->input('username');
echo $this->Form->input('password');
?>
</fieldset>
<?php echo $this->Form->end(__('ログイン')); ?>
</div>
