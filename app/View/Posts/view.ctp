<?php $this->assign('title', '記事詳細画面'); ?>
<h2><?php echo h($post['Post']['title']); ?></h2>

<p><small>投稿者: <?php echo $post['User']['username']; ?></small></p>
<p><small>作成日時: <?php echo $post['Post']['created']; ?></small></p>

<p><?php echo h($post['Post']['body']); ?></p>
