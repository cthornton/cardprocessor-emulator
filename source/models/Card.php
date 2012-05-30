<?php
class Card extends ModelBase {
  
  public static $STATUS_PENDING_ACTIVATION = 0, $STATUS_ACTIVE = 1, $STATUS_DEACTIVE = 2, $STATUS_STOLEN = 3;
  
  
  static $belongs_to = array(
    array('account'),
  );
  
  static $has_many = array(
    array('transactions'),
  );
  
  static $validates_presence_of = array(
     array('account'),
     array('status'),
     array('number'),
     array('expiration'),
  );
  
  static $validates_uniqueness_of = array(
    array('number'),
  );
  
  static $after_create = array('make_issued_card_transaction');
  
  /**
   * Creates a new 'card_issue' transaction for this card upon issuing.
   */
  function make_issued_card_transaction() {
    $this->createTransaction('card_issue', 0.0, 'card issued', null, true);
  }
  
  /**
   * Makes a transaction to this card
   * @param string $type the type of transaction
   * @param decimal $amount the amount to make a transaction for
   * @param string $description the description of the transaction
   * @param string $merchant the name of the merchant
   * @param boolean $force if TRUE, doesn't check to make sure the card is active. If FALSE, then checks to make
   * sure the card isn't active before making a transaction
   * @return Transaction the resulting Transaction object
   * @throws ResponseException if this card is inactive AND $force is false, OR if $amount causes the card balance
   * to fall below zero.
   */
  public function createTransaction($type, $amount, $description, $merchant = null, $force = false) {
    if($this->status != self::$STATUS_ACTIVE && !$force)
      throw new ResponseException("Cannot make a transaction to an inactive card", -5);
      
    $transaction = new Transaction(array(
      'card_id'     => $this->id,
      'account_id'  => $this->account_id,
      'amount'      => $amount,
      'description' => $description,
      'merchant'    => $merchant,
      'type'        => $type,
    ));
    Card::transaction(function() use($type, $amount, $description, $merchant, $transaction) {
      $transaction->save();
      $this->account->balance += $amount;
      $this->account->save();
    });
    return $transaction;
  }
  
}