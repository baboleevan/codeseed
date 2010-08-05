<?php
function has_property($obj, $prop) {
	$arr = get_object_vars($obj);
	foreach($arr as $key => $value) {
		if ($key == $prop) {
			return TRUE;
		}
	}
	return FALSE;
}

function get_value($obj, $props = array()) {
	if (empty($obj)) {
		return NULL;
	}

	if (!is_array($props)) {
		$props = array($props);
	}

	foreach($props as $prop) {
		if (has_property($obj, $prop)) {
			$obj = $obj->$prop;
		} else {
			return NULL;
		}
	}
	return $obj;
}

