<?php $this->assign('title', 'マイページ'); ?>
<h2>マイページ</h2>
<p>ユーザー名: <?php echo $post_user['User']['username']; ?></p>
<?php if (empty($post_user['User']['image'])) : ?>
ユーザー画像:未登録
<?php else : ?>
<p>ユーザー画像: <?php echo $this->Html->image($post_user['User']['image'], array('alt' => 'ユーザー画像')); ?></p>
<?php endif; ?>
<p>メールアドレス: <?php echo $post_user['User']['email']; ?></p>
<p>一言コメント: <?php echo $post_user['User']['comment']; ?></p>
<?php
if ($post_user['User']['id'] == $login_user['id'] || $login_user['role'] == 'admin') {
	echo $this->Html->link(
		'編集', array('controller' => 'users', 'action' => 'edit', $post_user['User']['id'])
	);
}
?>
