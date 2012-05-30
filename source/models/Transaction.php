<?php
class Transaction extends ModelBase {
  
  static $validates_presence_of = array(
     array('amount'),array('description'),array('type')
  );
  
  static $belongs_to = array(
    array('card'),
  );
  
  static $validates_numericality_of = array(
    array('amount')
  );
  
}