<?php
class Transaction extends ModelBase {
  
  static $validates_presence_of = array(
     array('company'), array('amount'), array('merchant'),array('description'),array('type')
  );
  
  static $belongs_to = array(
    array('card'),
  );
  
}