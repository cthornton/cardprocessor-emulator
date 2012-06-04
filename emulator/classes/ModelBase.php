<?php
/**
 * @package CardprocessorEmulator
 */
class ModelBase extends  ActiveRecord\Model {
  
  
  
  
  function save() {
    $result = parent::save();
    if(!$result) {
      $re = new ResponseException("Error saving " . get_class($this), -2);
      $re->response->body = implode("; ", $this->errors->full_messages());
      throw $re;
    }
    return true;
  }
}