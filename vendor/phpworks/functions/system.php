<?php
function parse_request_uri($uri) {
	if(strpos($uri, ROOT_FILE) == 1) {
		$uri = substr($uri, 1);
	} else {
		$uri = ROOT_FILE . $uri;
	}
	return explode('/', $uri);
}

function get_files($dir) {
	$result = array();
	$files = scandir($dir);
	foreach($files as $file) {
		if ($file == '.' or $file == '..') {
			continue;
		}
		if (is_dir($dir . '/' . $file)) {
			$result = array_merge($result, get_files($dir . '/' . $file));
		}
		if (strpos($file, '.') != 0 && is_file($dir . '/' . $file)) {
			$result[] = $dir . '/' . $file;
		}
	}
	print_r($result);
	return $result;
}

function require_once_all($files) {
	foreach($files as $file) {
		require_once($file);
	}
}

function require_once_dir($dir) {
	require_once_all(get_files($dir));
}
?>