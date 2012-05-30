<?php
class CardController extends Controller {
  
  protected $card;


  public function __construct() {
    $this->requireCompany();
    $this->card = Card::first(array(
      'joins' => array('person'),
      'conditions' => array('persons.company_id = ? AND cards.number = ?', $this->company->id, $_GET['cardNum']),
    ));
    if($this->card == null) throw new ResponseException('Card not found', -4);
  }
  
  public function action_index() {
    return $this->card->attributes();
  }
  
  
  public function action_transactions() {
    $l = array();
    foreach($this->card->transactions as $trans)
      $l[] = $trans->attributes();
    return array('transaction' => $l);
  }


}
?>