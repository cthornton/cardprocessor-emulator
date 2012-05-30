<?php

class CreateInitialTables extends Ruckusing_BaseMigration {

	public function up() {
    $queries = explode(';', file_get_contents('db/setup.sql'));
    foreach($queries as $q) {
      if(empty($q)) continue;
      $this->query($q);
    }
	}//up()

	public function down() {
	}//down()
}
?>