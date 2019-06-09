<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

class UsersController extends AppController {
	public $helpers = array('Html', 'Form', 'Flash');
	public $components = array('Security');

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('add', 'logout', 'edit', 'reset', 'reissue');
		$this->Security->blackHoleCallback = 'blackhole';
	}

	public function blackhole($type = 'csrf') {
		$this->Flash->error(__('不正な送信が行われました'));
		return $this->redirect(array('controller' => 'posts', 'action' => 'index'));
		exit();
	}

	public function login() {
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				$this->redirect($this->Auth->redirect());
			} else {
				$this->Flash->error(__('Invalid email or password, try again'));
			}
		}
	}

	public function logout() {
		$this->redirect($this->Auth->logout());
	}

	public function reset() {
		$this->User->set($this->request->data);
		unset($this->User->validate['email']['mail_unique']);
		if ($this->User->validates(array('fieldList' => array('email'))) && isset($this->request->data['User']['email'])) {
			$user = $this->User->findByEmail($this->request->data['User']['email']);
			if ($user === false || empty($user)) {
				$this->Flash->success('再発行用URLを送信しました');
			} else {
				$token = md5(uniqid(rand(),true));
				$reset_time = date('Y-m-d H:i:s');
				$update_data = array('User' => array('id' => $user['User']['id'], 'token' => $token, 'reseted' => $reset_time));
				$fields = array('token', 'reseted');
				if ($this->User->save($update_data, false, $fields)) {
					$email = new CakeEmail();
					$email->template('reset', 'default')
						->emailFormat('text')
						->viewVars(array('token' => $token))
						->to($user['User']['email'])
						->from('from@hoge.co.jp')
						->subject('パスワード再設定用URL')
						->send();

					$this->Flash->success('再発行用URLを送信しました');
				}
			}
		}
	}

	public function reissue($token = null) {
		if (isset($this->request->data['User']['password'])) {
			if (empty($token)) {
				$this->Flash->error('不正なアクセスです。再度お試しください。');
				return $this->redirect(array('controller' => 'Posts', 'action' => 'index'));
			} else {
				$user = $this->User->findByToken($token);
				if ($user === false || empty($user)) {
					$this->Flash->error('不正なアクセスです。再度お試しください。');
					return $this->redirect(array('controller' => 'Posts', 'action' => 'index'));
				} else {
					$limit_time  = date('Y-m-d H:i:s', strtotime('-30 minute'));
					if (strtotime($user['User']['reseted']) >= strtotime($limit_time)) {
						$update_data = array('User' => array('id' => $user['User']['id'], 'password' => $this->request->data['User']['password'],  'token' => null));
						$fields = array('password', 'token');
						if ($this->User->save($update_data, true, $fields)) {
							$this->Flash->success('パスワードを更新しました');
							return $this->redirect(array('action' => 'login'));
						}
						$this->Flash->error('パスワードを更新できませんでした。再度お試しください。');
					} else {
						$this->Flash->error('URLの有効期限が切れています。再度URLを発行してください。');
						return $this->redirect(array('controller' => 'Posts', 'action' => 'index'));
					}
				}
			}
		}
	}

	public function view($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$login_user = $this->Auth->user();
		$post_user = $this->User->findById($id);
		$this->set(compact('login_user', 'post_user'));
	}

	public function add() {
		$user = $this->Auth->user();
		$this->set('user', $user);
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Flash->success(__('The user has been saved'));
				return $this->redirect(array('controller' => 'Posts', 'action' => 'index'));
			}
			$this->Flash->error(
				__('The user could not be saved. Please, try again.')
			);
		}
	}

	public function edit($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$image = $this->request->data('User.image');
			if (empty($image['tmp_name'])) {
				if ($this->User->saveField('comment', $this->request->data('User.comment'))) {
					$this->Flash->success(__('The comment has been saved'));
					return $this->redirect(array('controller' => 'posts', 'action' => 'index'));
				}
				$this->Flash->error(
					__('The comment could not be saved. Please, try again.')
				);
			} else {
				$this->User->set($this->request->data);
				if ($this->User->validates(array('fieldList' => array('image')))) {
					$path = Configure::read('App.imageBaseUrl');
					$image_name = uniqid();
					move_uploaded_file($image['tmp_name'], $path . $image_name);

					$this->request->data['User']['image'] = $image_name;
					if ($this->User->save($this->request->data, array('validate' => false))) {
						$this->Flash->success(__('The user has been saved'));
						return $this->redirect(array('controller' => 'posts', 'action' => 'index'));
					}
					$this->Flash->error(
						__('The user could not be saved. Please, try again.')
					);
				} else {
					$this->Flash->error('画像ファイルを選択してください');
					return $this->redirect(array('action' => 'edit', $id));
				}
			}
		} else {
			$this->request->data = $this->User->findById($id);
			unset($this->request->data['User']['password']);
		}
	}

}
