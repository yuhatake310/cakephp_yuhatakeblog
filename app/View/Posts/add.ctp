<?php $this->assign('title', '新規投稿画面'); ?>
<h2>新規投稿</h2>
<?php
echo $this->Form->create('Post');
echo $this->Form->input('title');
echo $this->Form->input('body', array('rows' => '3'));
echo $this->Form->end('新規投稿');
?>
