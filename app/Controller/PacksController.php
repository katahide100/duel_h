<?php
App::uses('AppController', 'Controller');
/**
 * Packs Controller
 *
 * @property Pack $Pack
 */
class PacksController extends AppController {

public $uses = array('Pack','Link');
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Pack->recursive = 0;
		$this->set('packs', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Pack->exists($id)) {
			throw new NotFoundException(__('Invalid pack'));
		}
		$options = array('conditions' => array('Pack.' . $this->Pack->primaryKey => $id));
		$this->set('pack', $this->Pack->find('first', $options));
    $options = array('conditions' => array('Pack.id' => $id));
    $this->set('link', $this->Link->find('all', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Pack->create();
			if ($this->Pack->save($this->request->data)) {
				$this->Session->setFlash(__('The pack has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The pack could not be saved. Please, try again.'));
			}
		}
		$parts = $this->Pack->Part->find('list');
		$this->set(compact('parts'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Pack->exists($id)) {
			throw new NotFoundException(__('Invalid pack'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Pack->save($this->request->data)) {
				$this->Session->setFlash(__('The pack has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The pack could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Pack.' . $this->Pack->primaryKey => $id));
			$this->request->data = $this->Pack->find('first', $options);
		}
		$parts = $this->Pack->Part->find('list');
		$this->set(compact('parts'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
/*	public function delete($id = null) {
		$this->Pack->id = $id;
		if (!$this->Pack->exists()) {
			throw new NotFoundException(__('Invalid pack'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Pack->delete()) {
			$this->Session->setFlash(__('Pack deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Pack was not deleted'));
		$this->redirect(array('action' => 'index'));
	}*/
}
