<?php $this->assign('title', 'パスワード再設定申請画面'); ?>
<h2>パスワード再設定申請</h2>
<?php
echo $this->Form->create('User');
echo $this->Form->input('email');
echo $this->Form->end('送信');
?>
