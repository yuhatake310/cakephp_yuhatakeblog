<?php $this->assign('title', '記事編集画面'); ?>
<h2>記事の編集</h2>
<?php
echo $this->Form->create('Post');
echo $this->Form->input('title');
echo $this->Form->input('body', array('rows' => '3'));
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->Form->end('編集');
?>
