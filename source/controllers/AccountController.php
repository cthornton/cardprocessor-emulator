<?php
class AccountController extends Controller {
  
  protected $account;
  
  public function __construct() {
    $this->requireCompany();
    $this->account = Account::find($_GET['accountId']);
    if($this->account == null)
      throw new ResponseException('Account not found', -4);
  }
  
  public function action_view() {
    return array('account' => $this->account->attributes());
  }
  
  
  public function action_cards() {
    $l = array();
    foreach($this->account->cards as $c) $l[] = $c->attributes();
    return array('card' => $l);
  }
  
  
  public function action_transactions() {
    $l = array();
    foreach($this->account->transactions as $trans)
      $l[] = $trans->attributes();
    return array('transaction' => $l);
  }
  
  public function action_issueCard() {
    $card = new Card(array(
      'account_id'  => $this->account->id,
      'number'     => substr(number_format(time() * rand(),0,'',''),0,16), // random 16-digit card number
      'status'     => Card::$STATUS_PENDING_ACTIVATION, // active
      'expiration' => date('Y-m-d', time() +  157784630), // expires in 5 years
    ));
    $card->save();
    return array('card' => $card->attributes()); 
  }
  
  
}