<?php $this->assign('title', 'マイページ編集画面'); ?>
<h2>マイページの編集</h2>
<?php
echo $this->Form->create('User', ['type' => 'file']);
echo $this->Form->file('image');
echo $this->Form->input('comment');
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->Form->end('編集');
?>
