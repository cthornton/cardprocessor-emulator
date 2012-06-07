<?php
/**
 * The person controller represents a Person and his abilities
 */
class PersonController extends Controller {
  
  public function __construct() {
    $this->requireCompany();
  }
  
  /**
   * Views all persons associated with this company
   */
  public function action_index() {
    $list = array();
    foreach($this->company->persons as $person) {
      $list[] = $person->attributes();
    }
    return array('person' => $list);
  }
  
  /**
   * View a specific person with a given person ID
   */
  public function action_view() {
    $p = $this->getPerson();
    return array('person' => $p->attributes());
  }
  
  
  /**
   * Get a list of accounts for a given person
   */
  public function action_accounts() {
    $p = $this->getPerson();
    $l = array();
    foreach($p->accounts as $acct) $l[] = $acct->attributes();
    return array('account' => $l);
  }
  
  /**
   * Make a new account for a person
   */
  public function action_newAccount() {
    $p = $this->getPerson();
    $acct = new Account(array(
      'person_id' => $p->id,
      'balance'   => 0.0
    ));
    $acct->save();
    return array('account' => $acct->attributes());
  }
  
  /**
   * Creates a new person
   */ 
  public function action_new() {
    $person = new Person($this->paramsToAttributes(
      'first_name', 'last_name', 'address', 'address_2', 'city', 'state', 'zipcode', 'ssn', 'phone'));
    $person->company_id = $this->company->id;
    $person->save();
    return array('personId' => $person->id);
  }
  
  /**
   * Updates a person
   */
  public function action_update() {
    $p = $this->getPerson();
    $p->update_attributes(
        $this->paramsToAttributes('first_name', 'last_name', 'address', 'address_2', 'city', 'state', 'zipcode', 'ssn', 'phone'));
    return array('person' => $p->attributes());
  }

  /**
   * Gets a person based upon the current $_GET['personId'] and throws a ResponseException if the person could not be found
   */
  private function getPerson() {
    $p = Person::first(array('conditions' => array('company_id = ? AND id = ?', $this->company->id, $_GET['personId'])));
    if($p == null) throw new ResponseException('Person not found', -4);
    return $p;
  }

  
  
}


?>