<?php
class VolunteersController extends AppController {
    public $helpers = array('Html', 'Form');
	public $components = array('RequestHandler');
    
    public function index() {
        #TODO make this "upcoming birthdays"
        #search for birthmonth = lastmonth, thismonth, nextmonth
        #remember about dec/jan wrap!
        $thisMonth = date("n");
        $nextMonth = $thisMonth + 1 == 13 ? 1 : $thisMonth + 1;
        $lastMonth = $thisMonth - 1 == 0 ? 12 : $thisMonth - 1;
        $options = array(
            "conditions" => array("Volunteer.birthmonth" => array($lastMonth, $thisMonth, $nextMonth)),
            "order" => array('birthmonth' => 'asc', "birthday" => "asc")
            );
        $this->set('volunteers', $this->Volunteer->find("all", $options));
    }

    public function view($id = null) {
        $this->Volunteer->id = $id;
        $this->set('volunteer', $this->Volunteer->read());
    }

    function searchNormalize($x) {
        $x = str_replace("'", "", $x); #O'Brien -> OBrien
        $src = "-àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ";
        $dst = " aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY";
        return strtr(utf8_decode($x),utf8_decode($src),$dst); #Marie-Zoé -> Marie Zoe
    }

    function find($q) {
    	$terms = explode(" ", $this->searchNormalize($q));
    	$conditions = array('AND' => array());
    	foreach($terms as $term)
    	{
    		$conditions['AND'][] = array('Volunteer.searchableName LIKE' => "%$term%");
    	}
        return $this->Volunteer->find('all', array('conditions' => $conditions));
    }

    public function jump() {
    	$q = isset($this->params['url']['term']) ? $this->params['url']['term'] : "";
    	$result = $this->find($q);
    	if(count($result) == 1) {
    		$this->redirect(array('action' => 'view', $result[0]['Volunteer']['id']));
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
            $fullname = $this->request->data["Volunteer"]["firstname"] . " " . $this->request->data["Volunteer"]["lastname"];
            $this->request->data["Volunteer"]["searchableName"] = $this->searchNormalize($fullname);
	        if ($this->Volunteer->save($this->request->data)) {
	            $this->Session->setFlash('Data saved.', 'flash_success');
	            $this->redirect(array('action' => 'view', $this->Volunteer->id));
	        } else {
	            $this->Session->setFlash('Unable to save data.', 'flash_failure');
	        }
	    }
	}


}