<?php
// include system init
require_once(dirname(__FILE__) . '/../config/init.php');

// validate there are enough parameters
if ($argc < 3) {
	echonl("Usage:");
	echonl("\t`php script/generate.php model ModelName`");
	echonl("\t`php script/generate.php migration MigrationName`");
	echonl("\t`php script/generate.php controller ControllerName action_name1 action_name2 ...`");
	echonl("Example:");
	echonl("\t`php script/generate.php model User`");
	echonl("\t`php script/generate.php migration AddPrice`");
	echonl("\t`php script/generate.php controller Welcome login logout`");
	exit(0);
}

// init
array_shift($argv);
$kind = $argv[0];
array_shift($argv);
$name = $argv[0];
array_shift($argv);
$params = $argv;

if (!file_exists(Config::get('sys_classes'). '/generator/' . $kind . '_generator.class.php')) {
	echonl("No " . $kind . ' generator exist.');
	exit(0);
}

try {
	$classname = under_to_camel($kind) . 'Generator';
	$generator = new $classname($name, $params);
	$generator->generate();
} catch (Skip $e) {
	Context::get('db')->rollback();
} catch (DbError $e) {
	Context::get('db')->rollback();
	Log::error($e->getMessage());
	echonl($e->getMessage());
} catch (Exception $e) {
	Context::get('db')->rollback();
	Log::error($e->getMessage());
	echonl($e->getMessage());
}

