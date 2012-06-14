<?php
/**
 *
 * @package CardprocessorEmulator
 */
class CardController extends Controller {
  
  protected $card;

  /**
   * Gets the card based upon cardNumber or Card ID
   */
  public function __construct() {
    $this->requireCompany();
  }
  
  /**
   * Gets the single card for this company
   */
  protected function getCard() {
    $this->card = Card::first(array(
      'joins'      => 'LEFT JOIN accounts ON accounts.id = cards.account_id LEFT JOIN persons ON persons.id = accounts.person_id',
      'conditions' => array('persons.company_id = ? AND (cards.number = ? OR cards.id = ?) ', $this->company->id, $_REQUEST['cardNum'], $_REQUEST['cardId'])));
    if($this->card == null) throw new ResponseException('Card not found', -4);
  }
  
  public function action_index() {
    $cards = Card::all(array(
      'joins'      => 'LEFT JOIN accounts ON accounts.id = cards.account_id LEFT JOIN persons ON persons.id = accounts.person_id',
      'conditions' => array('persons.company_id = ?', $this->company->id)));
    $ret = array();
    foreach($cards as $card) $ret[] = $card->attributes();
    return array('card' => $ret);
  }
  
  public function action_view() {
    $this->getCard();
    return array('card' => $this->card->attributes());
  }
  
  public function action_activate() {
    $this->getCard();
    $this->card->status = Card::$STATUS_ACTIVE;
    $this->card->save();
    return $this->action_view();
  }
  
  public function action_deactivate() {
    $this->getCard();
    $this->card->status = Card::$STATUS_DEACTIVE;
    $this->card->save();
    return $this->action_view();
  }
  
  
  public function action_transactions() {
    $this->getCard();
    if(!empty($_REQUEST['days'])) {
      $days = intval($_REQUEST['days']) * 86400;
      $transactions = Transaction::all(array('conditions' => array('card_id = ? AND created_at >= FROM_UNIXTIME(?)', $this->card->id, time() - $days)));
    } else {
      $transactions = $this->card->transactions;
    }
    foreach($transactions as $trans)
      $l[] = $trans->attributes();
    return array('transaction' => $l);
  }
  
  
  public function action_loadBalance() {
    $this->getCard();
    return array('transaction' => $this->card->createTransaction('load_balance', $_GET['amount'], 'load balance')->attributes());
  }


}
?>