<?php
class CardController extends Controller {
  
  protected $card;

  /**
   * Gets the card based upon cardNumber or Card ID
   */
  public function __construct() {
    $this->requireCompany();
    /*
    $this->card = Card::first(array(
      'joins' => array('person'),
      'conditions' => array('persons.company_id = ? AND (cards.number = ? OR cards.id = ?)', $this->company->id, $_GET['cardNum'], $_GET['cardId']),
    )); */
    if($this->card == null) throw new ResponseException('Card not found', -4);
  }
  
  public function action_index() {
    return array('card' => $this->card->attributes());
  }
  
  public function action_view() {
    return $this->action_index();
  }
  
  public function action_deactivate() {
    $this->card->status = Card::$STATUS_DEACTIVE;
    $this->card->save();
    return $this->action_index();
  }
  
  
  public function action_transactions() {
    $l = array();
    foreach($this->card->transactions as $trans)
      $l[] = $trans->attributes();
    return array('transaction' => $l);
  }
  
  
  public function action_loadBalance() {
    return array('transaction' => $this->card->createTransaction('load_balance', $_GET['amount'], 'load balance')->attributes());
  }


}
?>