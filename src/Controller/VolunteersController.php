<?php
namespace App\Controller;

class VolunteersController extends AppController {
    public $helpers = array('Html', 'Form');
    public $components = array('RequestHandler');

    public function bounceIndex() {
        # HTTP 301: / -> /Volunteers
        $this->redirect(array('action' => 'index'));
    }

    public function index() {
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
                   ->select(["id", "birthday", "birthmonth", "firstname", "lastname"]) # limit the size of the query; you should be able to safely comment this out and still have the code work, since CakePHP has a smart ORM
                   ->where(["birthmonth in" => array($lastMonth, $thisMonth, $nextMonth)])
                   ->order(['birthmonth' => 'asc', "birthday" => "asc"]);

        $this->set('volunteers', $query);
    }

    public function view($id = null) {
        $query = $this->Volunteers
                   ->find()
                   ->where(["id" => $id]);
        $this->set('volunteer', $query->first());
    }

    function searchNormalize($x) {
        $x = str_replace("'", "", $x); #O'Brien -> OBrien
        $src = "-àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ";
        $dst = " aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY";
        return strtr(utf8_decode($x),utf8_decode($src),$dst); #Marie-Zoé -> Marie Zoe
    }

    function searchQuery($q) {
        $terms = explode(" ", $this->searchNormalize($q));

        $query = $this->Volunteers
                      ->find()
                      ->order(["id" => "asc"]);
        foreach($terms as $term)
        {
            $query = $query->where(['searchableName LIKE' => "%$term%"]); # XXX SQL injection here
        }
        return $query;
    }

    public function jump() {
        $q = $this->request->query('term');
        $query = $this->searchQuery($q);
        # Dig into the database and decide if we have a single result or not.
        # If we have a single result, jump to that person immediately,
        # otherwise show the full search UI with the search preloaded.
        # This is run when people _submit_ (i.e. press enter in) the search box.
        #
        # Making the decision is rather verbose and a bit off-kilter,
        # because we want to get the database to do the count for us (count($query->toList()) would first copy all results from SQL to PHP, then count them).
        # We end up tacking on an extra select count("*") to the previously-defined query which makes any other columns in that query meaningless, but whatever
        if($query->select(["count" => $query->func()->count("*")])->first()['count'] == 1) {
            $this->redirect(array('action' => 'view', $query->first()['id']));
        }
        else {
            $this->redirect(array('action' => 'search', "?" => array("term" => $q)));
        }
    }

    public function search() {
        $q = $this->request->query('term');
        $query = $this->searchQuery($q);
        $query = $query->select(["id"]); # minimize database traffic
                                         # weirdness: under CakePHP 3.6, without this here, the query defaults to querying for all columns in the table
                                         # but adding it restricts to just a single column.
                                         # further ->select() calls can add columns to that list
                                         # *but* only if there's an initial ->select() in the Controller;
                                         # columns may be added in the Views but without this initial select()
                                         # to constrain the list, the query object inside the views is stuck in full-heavy pick-all-columns mode.
        $this->set('volunteers', $query);
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
	    $volunteer = $this->Volunteers->query()->where(["id" => $id])->first();
	    if ($this->request->is('put')) { # XXX for some reason a POST request is detected by CakePHP 3.6 as a PUT but not a POST???

	        $data = $this->request->getData();

            $fullname = $data["firstname"] . " " . $data["lastname"];
            $data["searchableName"] = $this->searchNormalize($fullname);

	        $this->Volunteers->patchEntity($volunteer, $data);
	        if ($this->Volunteers->save($volunteer)) {
	            $this->Flash->success('Data saved.');
	            return $this->redirect(array('action' => 'view', $id));
	        } else {
	            $this->Flash->error('Unable to save data.');
	        }
	    }

        # XXX TODO: add error-checking to this query? Flash->error() if it fails?
        $this->set('volunteer', $volunteer);
	}


}
