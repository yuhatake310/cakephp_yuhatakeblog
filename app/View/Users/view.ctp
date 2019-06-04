<?php $this->assign('title', 'マイページ'); ?>
<h2>マイページ</h2>
<p>ユーザー名: <?php echo $user['User']['username']; ?></p>
<?php if (empty($user['User']['image'])) : ?>
ユーザー画像:未登録
<?php else : ?>
<p>ユーザー画像: <?php echo $this->Html->image($user['User']['image'], array('alt' => 'ユーザー画像')); ?></p>
<?php endif; ?>
<p>メールアドレス: <?php echo $user['User']['email']; ?></p>
<p>一言コメント: <?php echo $user['User']['comment']; ?></p>
<?php
if ($post_userid == $loginuser['id'] || $loginuser['role'] == 'admin') {
	echo $this->Html->link(
		'編集', array('controller' => 'users', 'action' => 'edit', $user['User']['id'])
	);
}
?>
