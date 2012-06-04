<?php
  require_once dirname(__FILE__) . '/../emulator/include.php';
  
  $d = new Dispatch;
  echo $d->handleRequest();
?>