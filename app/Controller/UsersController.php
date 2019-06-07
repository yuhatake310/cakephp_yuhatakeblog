<?php
App::uses('AppController', 'Controller');

class UsersController extends AppController {
	public $helpers = array('Html', 'Form', 'Flash');
	public $components = array('Security');

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('add', 'logout', 'edit', 'reset');
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
