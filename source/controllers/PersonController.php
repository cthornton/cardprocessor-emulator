<?php
class PersonController extends Controller {
  
  public function __construct() {
    $this->requireCompany();
  }
  
  public function action_index() {
    $list = array();
    foreach($this->company->persons as $person) {
      $list[] = $person->attributes();
    }
    return array('person' => $list);
  }
  
  public function action_view() {
    $p = $this->getPerson();
    return $p->attributes();
  }
  
  public function action_cards() {
    $cards = $this->getPerson()->cards;
    $l = array();
    foreach($cards as $c)
      $l[] = $c->attributes();
    return array('card' => $l);
  }
  
  public function action_issueCard() {
    $p = $this->getPerson();
    $card = new Card(array(
      'person_id'  => $p->id,
      'number'     => substr(number_format(time() * rand(),0,'',''),0,16), // random 16-digit card number
      'status'     => 1, // active
      'expiration' => date('Y-m-d', time() +  157784630), // expires in 5 years
      'balance'    => 0.0
    ));
    $card->save();
    return $card->attributes();
  }
  
  public function action_new() {
    $person = new Person($this->paramsToAttributes(
      'first_name', 'last_name', 'address', 'address_2', 'city', 'state', 'zipcode', 'ssn', 'phone'));
    $person->company_id = $this->company->id;
    $person->save();
    return array('personId' => $person->id);
  }

  private function getPerson() {
    $p = Person::first(array('conditions' => array('company_id = ? AND id = ?', $this->company->id, $_GET['personId'])));
    if($p == null) throw new ResponseException('Person not found', -4);
    return $p;
  }

  
  
}


?>