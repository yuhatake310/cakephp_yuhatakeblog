<h1>Blog posts</h1>
<p><?php echo $this->Html->link('Add Post', array('controller' => 'posts', 'action' => 'add')); ?></p>
<table>
<tr>
<th>Name</th>
<th>Title</th>
<th>Action</th>
<th>Created</th>
</tr>

<!-- $posts配列をループして、投稿記事の情報を表示 -->

<?php foreach ($posts as $post): ?>
<tr>
<td><?php echo $post['User']['username']; ?></td>
<td>
<?php
echo $this->Html->link(
	$post['Post']['title'],
	array('controller' => 'posts', 'action' => 'view', $post['Post']['id'])
);
?>
</td>
<td>
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
<td><?php echo $post['Post']['created']; ?></td>
</tr>
<?php endforeach; ?>
<?php unset($post); ?>
</table>
