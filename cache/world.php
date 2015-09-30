<?php

#-------------------------------------------------------
# world.php
# World completion values.
#
# (c) 2015, Marc St-Jacques <marc@geechef.com>
#
# Read the COPYING file for my very permissive and
# delicious licence.
#-------------------------------------------------------

if (!defined('CURR_DIR'))
	define('CURR_DIR', dirname(__FILE__));

include_once(CURR_DIR.'/db.php');

function world_by_id($id)
{
	$q = 'SELECT t1.name, t2.completed FROM characters, world where t1.name = t2.name';

	$arr = db_select_array($q);

	if (empty($arr))
		throw(new Exception("Unknown match for character $id");

	return $arr;
}

?>
