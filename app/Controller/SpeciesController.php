<?php
App::uses('AppController', 'Controller');
/**
 * Species Controller
 *
 * @property Species $Species
 */
class SpeciesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Species->recursive = 0;
		$this->set('species', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Species->exists($id)) {
			throw new NotFoundException(__('Invalid species'));
		}
		$options = array('conditions' => array('Species.' . $this->Species->primaryKey => $id));
		$this->set('species', $this->Species->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Species->create();
			if ($this->Species->save($this->request->data)) {
				$this->Session->setFlash(__('The species has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The species could not be saved. Please, try again.'));
			}
		} else {
			$options = array('fields' => 'MAX(Species.no) as max_id');
                        $result = $this->Species->find('first', $options);
			$this->set('max_id', $result[0]['max_id']);
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Species->exists($id)) {
			throw new NotFoundException(__('Invalid species'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Species->save($this->request->data)) {
				$this->Session->setFlash(__('The species has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The species could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Species.' . $this->Species->primaryKey => $id));
			$this->request->data = $this->Species->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Species->id = $id;
		if (!$this->Species->exists()) {
			throw new NotFoundException(__('Invalid species'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Species->delete()) {
			$this->Session->setFlash(__('Species deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Species was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
