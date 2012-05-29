<?php
class Person extends ModelBase {
  
  static $table_name = 'persons';
  
  static $belongs_to = array(
    array('company'),
  );
  
  static $has_many = array(
    array('cards')
  );
  
  
  static $validates_presence_of = array(
     array('ssn'), array('company')
  );
  
}