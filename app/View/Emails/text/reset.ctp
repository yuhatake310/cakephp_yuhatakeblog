記載したURLからパスワードの再設定を行ってください。(URLは30分間有効です。）

<?php echo Router::url(array('controller' => 'users', 'action' => 'reissue', $token), true); ?>
