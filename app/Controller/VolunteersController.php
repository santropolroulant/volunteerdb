<?php
class VolunteersController extends AppController {
    public $helpers = array('Html', 'Form');
	public $components = array('RequestHandler');
    
    public function index() {
        #TODO make this "upcoming birthdays"
    }

    function find($q) {
    	$terms = explode(" ", $q);
    	$conditions = array('AND' => array());
    	foreach($terms as $term)
    	{
    		$conditions['AND'][] = array('OR' => array(
    			array('Volunteer.firstname LIKE' => "%$term%"),
    			array('Volunteer.lastname LIKE' => "%$term%")
    			));
    	}
        return $this->Volunteer->find('all', array('conditions' => $conditions));
    }

    public function jump() {
    	$q = isset($this->params['url']['term']) ? $this->params['url']['term'] : "";
    	$result = $this->find($q);
    	if(count($result) == 1) {
    		$this->redirect(array('action' => 'edit', $result[0]['Volunteer']['id']));
    	}
    	else {
    		$this->redirect(array('action' => 'search', "?" => array("term" => $q)));
    	}
    }

    public function search() {
    	$q = isset($this->params['url']['term']) ? $this->params['url']['term'] : "";
        $this->set('volunteers', $this->find($q));
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