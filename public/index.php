<?php
  require_once dirname(__FILE__) . '/../source/include.php';
  
  $d = new Dispatch;
  echo $d->handleRequest();
?>