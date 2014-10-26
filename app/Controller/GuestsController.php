<?php
App::uses('AppController', 'Controller');
/**
 * Guests Controller
 *
 * @property Guest $Guest
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class GuestsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session', 'RequestHandler');

	public function index() {

		//$this->Guest->recursive = 1;
		if(!$this->Auth->loggedIn()){
			$this->redirect(array('controller' => 'Users', 'action' => 'login'));
			}
		$user = $this->Auth->user();
		$user_id = $user['id'];

		$this->Paginator->settings = array(
			'conditions' => array('Guest.user_id' => $user_id),
			'order' => array(
					'Guest.family_group' => 'asc'
				)
			
		);
		
		$this->set('guests', $this->Paginator->paginate());
		
		//this is an attempt to serialize the data from the 
		/*$sguests = $this->Guest->find('all');
		$this->set(array(
				'sguest' => $sguests,
				'_serialize' => array('posts')
			));*/

		//how many guests
		//$guests = $this->Guest->find('all');
		$this->set(array(
				'guests' => $this->Paginator->paginate(),
				'_serialize' => array('guests')

			));
		$guestTotal = $this->Guest->find('count', array('conditions' => array('Guest.user_id' => $user_id),));
		$this->set('guestTotal', $guestTotal);
		$yesTotal = $this->Guest->find('count', array('conditions' => array('Guest.user_id' => $user_id, 'Guest.acceptance' => true),));
		$this->set('yesTotal', $yesTotal);
	}

	public function rsvp($user_id) {

		$this->Guest->contain();
		
		$this->Paginator->settings = array(
			'conditions' => array('Guest.user_id' => $user_id),
			'order' => array(
					'Guest.family_group' => 'asc'
				)
			
		);
		
		//$this->set('guests', $this->Paginator->paginate());

		$this->set(array(
				'guests' => $this->Paginator->paginate(),
				'_serialize' => array('guests')

			));
		
	}

	public function add($numberInParty = null) {
		//authenticate the user and pull the user info 
		$user = $this->Auth->user();
		$this->set('user_id', $this->Auth->user('id') );
		
		//see if we know how many in party if not direct to that page
		if($numberInParty != null){
			$this->set('numberInParty', $numberInParty);
		}else{
			$this->redirect(array('action' => 'howmany'));
			}
			
		//create a unique family id	
		$familyId = $this->getLastGuest();
		$familyId = $familyId + 1;
		//pr($familyId);
		
		//see if any custom questions exists and setup
		if($user['question1']){
			$question1 = explode(',',$user['question1']);
		
			//set question for view
			$this->set('theQuestion1', $question1[0]);
			$question1cut = array_shift($question1);
		
			//set select for view
			$this->set('question1', $question1);
		}
		
		
		if ($this->request->is('post')) {
			
			$this->Guest->create();
			$data = $this->request->data;
			
			//first find last name first guest
			$firstLastName = $data['Guest'][0]['last_name'];
			
			//create family id last id + last name
			$family_group = $familyId . $firstLastName;
			
			//assign family id to all of the data
			$num = 0;
			
			while($num < $numberInParty){
				$data['Guest'][$num]['family_group'] = $family_group;
				$num++;
			}
			//
			pr($data);
			
			if ($this->Guest->saveAll($data['Guest'])) {
				$this->Session->setFlash(__('The guest has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The guest could not be saved. Please, try again.'));
			}
		}
	}

	public function addToParty($family_group = null, $user_id = null){
		

		if ($this->request->is('post')) {
			
			$this->Guest->create();
			$data = $this->request->data;

			$data['Guest'][0]['family_group'] = $family_group;
			$data['Guest'][0]['user_id'] = $user_id;
			
			
			if ($this->Guest->saveAll($data['Guest'])) {
				$this->Session->setFlash(__('The guest has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The guest could not be saved. Please, try again.'));
			}
		}


	}
	
	public function getLastGuest(){
		$lastGuest = $this->Guest->find('first', array('order' => array('Guest.id' => 'desc')));
		return $lastGuest['Guest']['id'];
	}
	
	public function howmany(){
		if ($this->request->is('post')) {
			$data = $this->request->data;
			$no = $data['Howmany']['howmany'];
			//pr($data);
			//pr($no);
			$this->redirect(array('action' => 'add', $no));
		}
	}
	
	public function edit($family_id = null, $user_id = null) {
		
		if ($this->request->is('post') || $this->request->is('put')) {
			pr($this->request->data);
			if ($this->Guest->saveMany($this->request->data)) {
				$this->Session->setFlash(__('The guest has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The guest could not be saved. Please, try again.'));
			}
		} 
		
		
		// find and set guest list
		$guest_group = $this->Guest->find('all', array( 'conditions' => array('Guest.user_id' => $user_id, 'Guest.family_group' => $family_id) ) );
		
		$this->set(array(
				'guests' => $guest_group,
				'_serialize' => array('guests')

			));


		$this->set('num', count($guest_group));
		$this->request->data = $guest_group;
	}

	public function delete($id = null) {
		$this->Guest->id = $id;
		if (!$this->Guest->exists()) {
			throw new NotFoundException(__('Invalid guest'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Guest->delete()) {
			$this->Session->setFlash(__('The guest has been deleted.'));
		} else {
			$this->Session->setFlash(__('The guest could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
