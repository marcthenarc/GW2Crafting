<?php

#-------------------------------------------------------
# json.php
# Wrapping json_decode() for hassle-free coding.
#
# (c) 2015, Marc St-Jacques <marc@geechef.com>
#
# Read the COPYING file for my very permissive and
# delicious licence.
#-------------------------------------------------------

# Transform a json string into a native object.
function json_get_object($json_string)
{
	$json_object = json_decode($json_string);

	if (!is_object($json_object))
	{
		# It can ca an array also
		if (!is_array($json_object))
			throw new Exception('Invalid JSON object from string.');
	}

	return $json_object;
}

# Fetch a specific field in a json object.
function json_get_field(&$json_object, $field)
{
	if (!isset($json_object->{$field}))
		throw new Exception("Unknown field '$field' in JSON object.");

	return $json_object->{$field};
}

?>
