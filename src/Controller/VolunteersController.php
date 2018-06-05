<?php
namespace App\Controller;

use Cake\Http\Exception\NotFoundException;

class VolunteersController extends AppController {
    public $helpers = array('Html', 'Form', 'Paginator');
    public $components = array('RequestHandler', 'Paginator');

    public $paginate = [
        'limit' => 20,
    ];

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
        $volunteer = $query->first();
        if($volunteer) {
            $this->set('volunteer', $volunteer);
        } else {
            throw new NotFoundException();
        }
    }

    function searchNormalize($x) {
        $x = str_replace("'", "", $x); #O'Brien -> OBrien
        $src = "-àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ";
        $dst = " aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY";
        return strtr(utf8_decode($x),utf8_decode($src),$dst); #Marie-Zoé -> Marie Zoe
    }

    public function search() {

        $query = $this->Volunteers
                      ->find()
                      ->order(["firstname" => "asc", "lastname" => "asc"]);
        $query = $query->select(["id", "firstname", "lastname", "orientationdate"]); # minimize database traffic
                                         # weirdness: under CakePHP 3.6, without this here, the query defaults to querying for all columns in the table
                                         # but adding it restricts to just a single column.
                                         # further ->select() calls can add columns to that list
                                         # *but* only if there's an initial ->select() in the Controller;
                                         # columns may be added in the Views but without this initial select()
                                         # to constrain the list, the query object inside the views is stuck in full-heavy pick-all-columns mode.

        $term = $this->request->query('term');
        $term = $this->searchNormalize($term);
        $query = $query->where(['searchableName LIKE' => "%$term%"]); # XXX SQL injection here

        # Special Case:
        # if a user has typed in an unambiguous name for a volunteer,
        # into the web UI, then jump immediately to it.
        if(!$this->request->is('json')) {
            if($query->count() == 1) { # a single result == unambiguous
                $this->redirect(array('action' => 'view', $query->select(["id"])->first()['id']));
            }
        }

        $this->set('search_term', $term);
        $this->set('volunteers', $this->paginate($query));

        # Enable /search.json
        $this->set('_serialize', 'volunteers');
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
