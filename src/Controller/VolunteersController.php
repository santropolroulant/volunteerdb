<?php
namespace App\Controller;

use \Datetime;
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
        # TODO: replace this 'birthmonth in' thing with using datetime <=
        #       see https://github.com/santropolroulant/volunteerdb/issues/5
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
        $query = $query->where(function ($exp, $q) use ($query, $term) {
                    return $exp->like(
                         # compare "$firstname $lastname" ~ "%$term%"
                         $query->func()->concat([
                                 'firstname' => 'identifier',
                                 " ",
                                 'lastname' => 'identifier']),
                         "%$term%" # subtlety: this is *not* a SQL injection because PHP this whole expression gets wrapped up in a bound SQL var by like().
                         );
                    });

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

    public function edit($id = null) {

        $data = $this->request->getData();
        # Unpack the birthdate field into the older birthday/month/year fields
        # TODO: this will be dropped once we do https://github.com/santropolroulant/volunteerdb/issues/5
        if(isset($data["birthdate"])) {
            $_birthdate = new DateTime($data["birthdate"]);
            $data["birthday"] = $_birthdate->format('d');
            $data["birthmonth"] = $_birthdate->format('m');
            $data["birthyear"] = $_birthdate->format('Y');
            unset($data["birthdate"]);
        } else {
            $data["birthday"] = "";
            $data["birthmonth"] = "";
            $data["birthyear"] = "";
        }


        # Determine the active Volunteer object
        if($this->request->is(['get', 'put'])) {
            # read/update loads the current state from the DB
            if($id) {
                $volunteer = $this->Volunteers
                                  ->query()
                                  ->where(["id" => $id])
                                  ->first();

                # /edit/{id} is only okay if $id references a real volunteer
                if(!$volunteer) {
                    throw new NotFoundException();
                }
            } else {
                # /edit/ is always okay: it means create a new volunteer
                # but we don't actually create the object here yet; we first load an empty form
                # and then in the POST when the user submits that form back to us,
                # there's where we call newEntity().
                $volunteer = NULL;
            }

        } else if ($this->request->is('post')) {
            # Create
            $volunteer = $this->Volunteers->newEntity($data);
        }

        # Update
        if($this->request->is('put')) {
            $this->Volunteers->patchEntity($volunteer, $data);
        }


        # Write the volunteer object to the DB, as requested
        if($this->request->is(['post', 'put'])) {
            # Create/Update saves the changes back
            if ($this->Volunteers->save($volunteer)) {
                $this->Flash->success('Data saved.');
                return $this->redirect(array('action' => 'view', $volunteer["id"]));
            } else {
                $this->Flash->error('Unable to save data.');
            }
        } else if ($this->request->is('delete')) {
            # XXX TODO there should be error-checking wrapped around this execute() call
            if($this->Volunteers->query()->delete()->where(["id" => $id])->execute()) {
                $this->Flash->success('Deleted.');
                return $this->redirect("/"); # this is important; otherwise it will try to load the non-existent delete.ctp file
            } else {
                $this->Flash->error('Deletion failed.'); # TODO: extract better error message?
                # this should bounce us back to the same /edit/{id} page we were on when the user clicked Delete
            }
        }

        # For get/post/put (i.e. read/create/update), *after* saving to the DB,
        # shove in birthdate as an addendum field
        # This is a stepping-stone towards https://github.com/santropolroulant/volunteerdb/issues/5
        try {
          $volunteer["birthdate"] = new DateTime($volunteer["birthyear"]."-".$volunteer["birthmonth"]."-".$volunteer["birthday"]);
          unset($volunteer["birthday"]);
          unset($volunteer["birthmonth"]);
          unset($volunteer["birthyear"]);
        } catch(\Exception $e) {
        }
        
        $this->set('volunteer', $volunteer);
    }


}
