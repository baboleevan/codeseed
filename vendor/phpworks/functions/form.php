<?php
function has_property($obj, $prop) {
	$arr = get_object_vars($obj);
	foreach($arr as $key => $value) {
		if ($key == $prop) {
			return true;
		}
	}
	return false;
}

function get_value($obj, $props = array()) {
	global $flash;

	if (!is_array($props)) {
		$props = array($props);
	}

	if (!has_property($obj, $props[0])) {
		$obj = unserialize(serialize($flash->get('that')));
	}

	if (empty($obj)) {
		return null;
	}

	foreach($props as $prop) {
		if (has_property($obj, $prop)) {
			$obj = $obj->$prop;
		} else {
			return null;
		}
	}
	return $obj;
}

