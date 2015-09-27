<?php

#-------------------------------------------------------
# update_characters.php
# Retrieves and stores character info and updates.
#
# (c) 2015, Marc St-Jacques <marc@geechef.com>
#
# Read the COPYING file for my very permissive and
# delicious licence.
#-------------------------------------------------------

if (!defined('CURR_DIR'))
	define('CURR_DIR', dirname(__FILE__));

include_once(CURR_DIR.'/api.php');
include_once(CURR_DIR.'/db.php');

try
{
	# Get characters from db.
	$db_chars = db_select_array_one_field('SELECT id, name FROM characters ORDER BY id', 'name');

	# Get characters from site.
	$api_chars = json_get_object(api_get_characters());

	foreach ($api_chars as $ac)
	{
		# Get details on each character from the site.
		$spec = api_get_specific_character($ac);
		$name = json_get_field(json_get_object($spec), 'name');

		$i = array_search($ac, $db_chars);

		# Can't find that character on the db ? Insert it.
		if ($i === false)
			db_insert('characters', array('json'=>$spec, 'name'=>$name));
		else
		{
			# Update json
			db_update('characters', array('json'=>$spec), array('id'=>$i));

 			# Remove character from the array.
			unset($db_chars[$i]);
		}
	}

	# Do we have any characters left from the DB? Guess they are deleted characters.
	foreach ($db_chars as $k=>$v)
		db_delete('characters', array('id'=>$k));
	
}
catch (Exception $e)
{
	echo $e->GetMessage();
}
