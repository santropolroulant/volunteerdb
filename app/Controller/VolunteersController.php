<?php
class VolunteersController extends AppController {
    public $helpers = array('Html', 'Form');

    public function index() {
        #TODO make this "upcoming birthdays"
    }

    public function search() {
    	$q = $this->params['url']['q'];
    	$q = isset($q) ? $q : "";
    	$terms = explode(" ", $q);
    	$conditions = array('AND' => array());
    	foreach($terms as $term)
    	{
    		$conditions['AND'][] = array('OR' => array(
    			array('Volunteer.firstname LIKE' => "%$term%"),
    			array('Volunteer.lastname LIKE' => "%$term%")
    			));
    	}
        $this->set('volunteers', $this->Volunteer->find('all', array('conditions' => $conditions)));
    }

	public function edit($id = null) {
	    $this->Volunteer->id = $id;
	    if ($this->request->is('get')) {
	        $this->request->data = $this->Volunteer->read();
	    } else {
	        if ($this->Volunteer->save($this->request->data)) {
	            $this->Session->setFlash('Your Volunteer has been updated.', 'flash_success');
	            $this->redirect(array('action' => 'index'));
	        } else {
	            $this->Session->setFlash('Unable to update your Volunteer.', 'flash_failure');
	        }
	    }
	}


}