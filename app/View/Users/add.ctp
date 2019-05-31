<?php $this->assign('title', '会員登録画面'); ?>
<div class="users form">
<?php echo $this->Form->create('User'); ?>
<fieldset>
<legend><?php echo __('会員登録'); ?></legend>
<?php
echo $this->Form->input('username');
echo $this->Form->input('email');
echo $this->Form->input('password');
?>
<?php if (isset($user['role']) && $user['role'] === 'admin') : ?>
<?php
echo $this->Form->input('role', array(
	'options' => array('admin' => 'Admin', 'author' => 'Author')
));
?>
<?php else : ?>
<?php echo $this->Form->hidden('role', ['value' => 'author']); ?>
<?php endif; ?>
</fieldset>
<?php echo $this->Form->end(__('登録')); ?>
</div>
