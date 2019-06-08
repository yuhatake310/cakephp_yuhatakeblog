<?php
App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class User extends AppModel {
	public $validate = array(
		'username' => array(
			'required' => array(
				'rule' => 'notBlank',
				'message' => 'ユーザー名を入力してください'
			)
		),
		'image' => array(
			'file_extension' => array(
				'rule' => array('extension', array('jpg', 'jpeg', 'gif', 'png')),
				'message' => '画像ファイルを選択してください',
				'allowEmpty' => true,
			)
		),
		'email' => array(
			'required' => array(
				'rule' => 'notBlank',
				'message' => 'メールアドレスを入力してください'
			),
			'mail_format' => array(
				'rule' => 'email',
				'message' => '正しいメールアドレスを入力してください'
			),
			'mail_unique' => array(
				'rule' => 'isUnique',
				'message' => '入力したメールアドレスは既に登録されています'
			)
		),
		'password' => array(
			'required' => array(
				'rule' =>  'notBlank',
				'message' => 'パスワードを入力してください'
			)
		),
		'role' => array(
			'valid' => array(
				'rule' => array('inList', array('admin', 'author')),
				'message' => '有効な役割を入力してください',
				'allowEmpty' => false
			)
		)
	);

	public function beforeSave($options = array()) {
		if (isset($this->data[$this->alias]['password'])) {
			$passwordHasher = new BlowfishPasswordHasher();
			$this->data[$this->alias]['password'] = $passwordHasher->hash(
				$this->data[$this->alias]['password']
			);
		}
		return true;
	}
}
