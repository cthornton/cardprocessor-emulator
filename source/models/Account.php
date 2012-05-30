<?php
class Account extends ModelBase {
  
  static $belongs_to = array(
    array('account'),
  );
  
  static $has_many = array(
    array('cards'),
    array('transactions'),
  );
  
  static $validates_numericality_of = array(
    array('balance', 'greater_than_or_equal_to' => 0)
  );
}
?>