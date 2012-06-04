<?php
/**
 * The account controller handles account related tasks, such as viewing an account, viewing
 * cards, viewing transactions and more.
 *
 * At minimum, the request URL must look like: <br>
 * <code>example.com/?username=companyUsername&password=companyPassword&accountId=accountId</code>
 *
 * @package CardprocessorEmulator
 * @see Account for more information on properties, etc
 */
class AccountController extends Controller {
  
  protected $account;
  
  /**
   * Ensures that the user is logged in and loads the requested account.
   *
   * Loads the account based upon the $_REQUEST['accountId'] varaible. Will raise an exception if
   * the account associated with the current company was not found.
   * @throws ResponseException if the given accountId is not associated with the current company
   */
  public function __construct() {
    $this->requireCompany();
    
    // Ensure that we're accessing a card we have permission to access
    $this->account = Account::first(array(
      'joins'      => array('person'),
      'conditions' => array('accounts.id = ? AND persons.company_id = ?', $_REQUEST['accountId'], $this->company->id)));
    
    if($this->account == null) throw new ResponseException('Account not found', -4);
  }
  
  
  /**
   * Returns an XML format of the current Account
   */
  public function action_view() {
    return array('account' => $this->account->attributes());
  }
  
  /**
   * Returns an XML list of cards associated with this account
   * @see Card
   */
  public function action_cards() {
    $l = array();
    foreach($this->account->cards as $c) $l[] = $c->attributes();
    return array('card' => $l);
  }
  
  
  /**
   * Views a list of transactions associated with this account
   * @see Transaction
   */
  public function action_transactions() {
    $l = array();
    foreach($this->account->transactions as $trans)
      $l[] = $trans->attributes();
    return array('transaction' => $l);
  }
  
  /**
   * Issues a card for this account and returns the card details
   * @see Card
   */
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