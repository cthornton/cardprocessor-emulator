<?php
/**
 * @package CardprocessorEmulator
 */
class Dispatch {
  
  public static $format = 'xml', $path;
  
  public static $TYPES = array('json', 'xml');
  
  public function __construct() {
    // var_dump($_SERVER);
    $toUse = empty($_SERVER['PATH_INFO']) ? $_SERVER['REDIRECT_URL'] : $_SERVER['PATH_INFO'];
    $p = empty($_GET['q']) ?  $toUse : $_GET['q'];
    self::$path = explode('/', $p);
    // var_dump(self::$path);    
    array_shift(self::$path);
    $type = $_GET['format'];
    if(!empty($type) && in_array($type, self::$TYPES))
      self::$format = $type;
    header('content-type: text/' . self::$format);
  }
  
  
  public function handleError($errno, $errstr, $errfile, $errline, $errcontext) {
    $type = "";
    switch($errno) {
    case E_USER_ERROR:
      $type = 'Error';
      break;
    case E_USER_WARNING:
      $type = 'Warning';
      break;
    case E_USER_NOTICE:
      $type = 'Notice';
      break;
    case E_STRICT: // Ignore Strict and notice
    case E_NOTICE:
      return;
      break;
    default:
      $type = 'Unknown';
    }
    
    $re = new ResponseException('Internal Server Error: ' . "[$type] $errstr", 500, 500, 'Internal Server Error');
    $body = "At $errfile #$errline (errno #$errno)\n";
    $re->response->body = $body;
    die($re->response->toFormat());
    
  }
  
  
  public function handleRequest() {
    set_error_handler(array($this, 'handleError'));
    try {
      $notFoundEx = new ResponseException('Unknown Action', 404, 404, 'Not Found');
      $p = self::$path;
      $cname = $p[0];
      $action = empty($p[1]) ? 'index' : $p[1];
      
      # Pluck out controller info, etc
      if(empty($cname)) throw $notFoundEx;
      $cname .= 'Controller';
      $file = SRC_DIR . '/controllers/' . $cname . '.php';
      if(!file_exists($file)) throw $notFoundEx;
      require_once($file);
      $controller = new $cname;
      
      $action = 'action_' . $action;
      if(!method_exists($controller, $action)) throw $notFoundEx;
      
      $result = $controller->$action();
      $response = new Response($result);
      
      return $response->toFormat();
      
    } catch(ResponseException $re) {
      $re->head();
      return $re->response->toFormat();
    } catch(Exception $e) {
      $re = new ResponseException('Internal Server Error: ' . $e->getMessage(), 500, 500, 'Internal Server Error');
      $re->response->body = $e->getTraceAsString();
      return $re->response->toFormat();
    }
  }
  
}