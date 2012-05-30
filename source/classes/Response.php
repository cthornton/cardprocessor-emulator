<?php
class Response {
  
  public $errorString, $errorNo = 0, $body = array();
  
  public function __construct($body = array()) {
    $this->body = $body;
  }
  
  public function toJson() {
    return json_encode($this->toArray());
  }
  
  public function toXml() {
    $xml  = '<?xml version="1.0" encoding="UTF-8" ?>';
    $xml .= '<response>';
    $xml .= '<error code="' . $this->errorNo . '" errors="' . ($this->errorNo != 0 ? "true" : "false") . '">' . htmlentities($this->errorString) . '</error>';
    $xml .= '<body>';
    $xml .= $this->generateXmlFromArray($this->body);
    $xml .= '</body>';
    $xml .= '</response>';
    return $xml;
  }
  
  public function toFormat($format = null) {
    if($format == null) $format = Dispatch::$format;
    switch($format) {
      case 'xml': return $this->toXml();
      default: return $this->toJson();
    }
  }
  
  protected function toArray() {
    return array(
      'errors'      => ($this->errorNo != 0),
      'errorString' => $this->errorString,
      'errorCode'   => $this->errorNo,
      'body'        => $this->body
    );
  }
  
  
  
  protected function generateXmlFromArray($array, $parent = null) {
    if(!is_array($array)) return htmlentities("" . $array);
    if(count($array) == 1 && is_array(end($array)))
      return $this->generateXmlFromArray(end($array), key($array));
    $xml = '';
    foreach($array as $key=>$val) {
      if(is_int($key) && $parent != null) $key = $parent;
      elseif(is_int($key)) $key = "entry";
      $xml .= "<$key>" . $this->generateXmlFromArray($val, $key) . "</$key>";
    }
    return $xml;
  }
  
}