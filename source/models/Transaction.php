<?php
class Transaction extends ModelBase {
  
  static $validates_presence_of = array(
     array('amount'),array('description'),array('type'), array('account')
  );
  
  static $belongs_to = array(
    array('card'),
    array('account'),
  );
  
  static $validates_numericality_of = array(
    array('amount')
  );
  
}