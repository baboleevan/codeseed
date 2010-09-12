<?php
// include system init 
require_once(dirname(__FILE__) . '/../config/environment.php');

// connect db connection
$db = get_db();
$db->connect();

// init table
$tables = $db->get_tables();

// init sessions table
if (in_array('sessions', $tables)) {
	$migration = new CreateSessions();
	$migration->down();
}

// init version table
if (in_array('schema_version', $tables)) {
	$migration = new CreateSchemaVersion();
	$migration->down();
}

