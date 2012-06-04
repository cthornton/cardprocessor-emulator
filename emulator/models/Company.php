<?php
/**
 *
 * @package CardprocessorEmulator
 */
class Company extends ModelBase {
  
  static $validates_presence_of = array(
     array('username'), array('password'), array('name')
  );
  
  static $validates_uniqueness_of = array(
    array('username'),
    array('name')
  );
  
  static $has_many = array(
    array('persons'),
  );
  
}