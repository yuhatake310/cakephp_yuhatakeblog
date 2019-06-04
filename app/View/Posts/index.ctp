<?php $this->assign('title', 'ブログTop'); ?>
<h2>ブログ記事一覧</h2>
<p><?php echo $this->Html->link('会員登録', array('controller'=>'users','action'=>'add')); ?></p>
<?php if (isset($user)) : ?>
<p><?php echo $this->Html->link('新規投稿', array('controller' => 'posts', 'action' => 'add')); ?></p>
<p><?php echo $this->Html->link('ログアウト', array('controller'=>'users','action'=>'logout')); ?></p>
<?php else : ?>
<p><?php echo $this->Html->link('ログイン', array('controller'=>'users','action'=>'login')); ?></p>
<?php endif; ?>
<table>
<tr>
<th>投稿ID</th>
<th>投稿者名</th>
<th>タイトル</th>
<th>本文</th>
<th>作成日時</th>
</tr>

<!-- $posts配列をループして、投稿記事の情報を表示 -->

<?php foreach ($posts as $post): ?>
<tr>
<td><?php echo $post['Post']['id']; ?></td>
<td>
<?php
echo $this->Html->link(
	$post['User']['username'],
	array('controller' => 'users', 'action' => 'view', $post['User']['id'])
);
?>
</td>
<td>
<?php
echo $this->Html->link(
	$post['Post']['title'],
	array('controller' => 'posts', 'action' => 'view', $post['Post']['id'])
);
?>


<?php if ($post['User']['id'] == $user['id'] || $user['role'] == 'admin') : ?>
<?php
echo $this->Html->link(
	'編集', array('action' => 'edit', $post['Post']['id'])
);
?>

<?php
echo $this->Form->postLink(
	'削除',
	array('action' => 'delete', $post['Post']['id']),
	array('confirm' => 'Are you sure?')
);
?>
<?php endif; ?>
</td>
<td><?php echo $post['Post']['body']; ?></td>
<td><?php echo $post['Post']['created']; ?></td>
</tr>
<?php endforeach; ?>
<?php unset($post); ?>
</table>
