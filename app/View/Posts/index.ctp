<h1>Blog posts</h1>
<?php if (isset($user)) : ?>
<p><?php echo $this->Html->link('新規投稿', array('controller' => 'posts', 'action' => 'add')); ?></p>
<p><?php echo $this->Html->link('ログアウト', array('controller'=>'users','action'=>'logout')); ?></p>
<?php else : ?>
<p><?php echo $this->Html->link('会員登録', array('controller'=>'users','action'=>'add')); ?></p>
<p><?php echo $this->Html->link('ログイン', array('controller'=>'users','action'=>'login')); ?></p>
<?php endif; ?>
<table>
<tr>
<th>Id</th>
<th>Name</th>
<th>Title</th>
<th>Body</th>
<th>Created</th>
</tr>

<!-- $posts配列をループして、投稿記事の情報を表示 -->

<?php foreach ($posts as $post): ?>
<tr>
<td><?php echo $post['Post']['id']; ?></td>
<td><?php echo $post['User']['username']; ?></td>
<td>
<?php
echo $this->Html->link(
	$post['Post']['title'],
	array('controller' => 'posts', 'action' => 'view', $post['Post']['id'])
);
?>
<br>
<?php
echo $this->Form->postLink(
	'Delete',
	array('action' => 'delete', $post['Post']['id']),
	array('confirm' => 'Are you sure?')
);
?>

<?php
echo $this->Html->link(
	'Edit', array('action' => 'edit', $post['Post']['id'])
);
?>
</td>
<td><?php echo $post['Post']['body']; ?></td>
<td><?php echo $post['Post']['created']; ?></td>
</tr>
<?php endforeach; ?>
<?php unset($post); ?>
</table>
