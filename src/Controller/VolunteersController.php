<?php
namespace App\Controller;

class VolunteersController extends AppController {
    public $helpers = array('Html', 'Form');
	public $components = array('RequestHandler');
    
    public function upcomingBirthdays() {
        #TODO make this "upcoming birthdays"
        #search for birthmonth = lastmonth, thismonth, nextmonth
        #remember about dec/jan wrap!
        $thisMonth = date("n");
        $nextMonth = $thisMonth + 1 == 13 ? 1 : $thisMonth + 1;
        $lastMonth = $thisMonth - 1 == 0 ? 12 : $thisMonth - 1;
        #$options = array(
        #    "conditions" => array(,
        #    "order" =>             );
        $query = $this->Volunteers
                   ->find()
                   ->select(["birthday", "birthmonth", "firstname", "lastname"]) # limit the size of the query; you should be able to safely comment this out and still have the code work, since CakePHP has a smart ORM
                   ->where(["birthmonth in" => array($lastMonth, $thisMonth, $nextMonth)])
                   ->order(['birthmonth' => 'asc', "birthday" => "asc"]);

        $this->set('volunteers', $query);
    }

    public function view($id = null) {
        $query = $this->Volunteers
                   ->find()
                   ->where(["id" => $id]);
        debug($query->first());
        $this->set('volunteer', $query->first());
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
        return $this->Volunteer->find('all', array('conditions' => $conditions, "order" => "id"));
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

	public function delete($id = null) {
	    if ($this->request->is('post') && $id) {
	        # XXX TODO there should be error-checking wrapped around this execute() call
	        $this->Volunteers->query()->delete()->where(["id" => $id])->execute();
	        $this->Flash->success('Deleted.');
	    } else {
	        $this->Flash->error('Nothing to delete.');
        }
	}

	public function edit($id = null) {
	    if ($this->request->is('get')) {
	        $this->set('volunteer', $this->Volunteers->query()->where(["id" => $id])->first());
	        # XXX TODO: add error-checking to this query
	    } else if ($this->request->is('post')) {
            $fullname = $this->request->data["Volunteer"]["firstname"] . " " . $this->request->data["Volunteer"]["lastname"];
            $this->request->data["Volunteer"]["searchableName"] = $this->searchNormalize($fullname);
	        if ($this->Volunteers->save($this->request->data)) {
	            $this->Flash->success('Data saved.');
	            $this->redirect(array('action' => 'view', $id));
	        } else {
	            $this->Flash->error('Unable to save data.');
	        }
	    }
	}


}
