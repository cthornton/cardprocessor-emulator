<?php
class Controller {
  
  protected $company;
  
  protected function requireCompany() {
    $company = Company::first(array('conditions' => array('username = ? AND password = ?', $_GET['username'], $_GET['password'])));
    if($company == null) throw new ResponseException('Unable to find company', -3);
    $this->company = $company;
  }
  
  
  protected function paramsToAttributes() {
    $args = func_get_args();
    $parsed = array();
    foreach($args as $arg) {
      if(!empty($_REQUEST[$arg]))
        $parsed[$arg] = $_REQUEST[$arg];
    }
    return $parsed;
  }
  
}