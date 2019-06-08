<?php $this->assign('title', 'パスワード再発行画面'); ?>
<h2>パスワード再発行</h2>
<?php
echo $this->Form->create('User');
echo $this->Form->input('password');
echo $this->Form->end('更新');
?>
