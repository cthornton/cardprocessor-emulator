<?php
/**
 * @package CardprocessorEmulator
 */
class ResponseException extends Exception {
  
  public $response, $httpCode, $httpString;
  
  public function __construct($errorString, $errorCode = -1, $httpCode = -1, $httpString = '') {
    parent::__construct($errorString, $errorCode);
    $this->response = new Response();
    $this->response->errorString = $errorString;
    $this->response->errorNo     = $errorCode;
    $this->httpCode = $httpCode;
    $this->httpString = $httpString;
  }
  
  
  public function head() {
    if($this->httpCode != -1) {
      header('HTTP/1.1 ' . $this->httpCode . ' ' . $this->httpString);
    }
  }
  
  
}