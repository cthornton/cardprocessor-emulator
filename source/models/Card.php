<?php
class Card extends ModelBase {
  
  static $belongs_to = array(
    array('person'),
  );
  
  static $validates_presence_of = array(
     array('person'), array('status'), array('number'), array('expiration'), array('balance')
  );
  
  static $validates_uniqueness_of = array(
    array('number'),
  );
  
}