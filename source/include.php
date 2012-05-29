<?php
date_default_timezone_set('America/Phoenix');


define('SRC_DIR', realpath(dirname(__FILE__)));
define('INC_DIR', realpath(SRC_DIR . '/../include'));

// Includes
require_once INC_DIR . '/activerecord/ActiveRecord.php';

// Initialize ActiveRecord
ActiveRecord\Config::initialize(function($cfg) {
  $configs = require_once(SRC_DIR . '/../config.php');
  $cnxstr = 'mysql://' . $configs['user'] . ':' . $configs['pass'] . '@' . $configs['host'] . '/' . $configs['name'];
  $cfg->set_model_directory(SRC_DIR . '/models');
  $cfg->set_connections(array(
    'production' => $cnxstr,
    'development' => $cnxstr
  ));
});

// Autload Stuff
spl_autoload_register(function($class) {
  $dirs = array('classes', 'models', 'controllers');
  foreach($dirs as $dir) {
    $file = SRC_DIR . '/' . $dir . '/'. $class . ".php";
    if(file_exists($file)) require_once($file);
  }
});

?>