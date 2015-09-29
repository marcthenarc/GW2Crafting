<?php

#-------------------------------------------------------
# update_target.php
# Refreshes the targets table.
#
# (c) 2015, Marc St-Jacques <marc@geechef.com>
#
# Read the COPYING file for my very permissive and
# delicious licence.
#-------------------------------------------------------

if (!defined('CURR_DIR'))
	define('CURR_DIR', dirname(__FILE__));

include_once(CURR_DIR.'/target.php');
include_once(CURR_DIR.'/db.php');

try
{
	db_query('DELETE FROM targets WHERE target != ingredient');
	$arr = db_select_array_one_field('SELECT * FROM targets', 'target');

	foreach ($arr as $v)
		target_new($v, false);
		
}
catch(Exception $e)
{
	echo $e->getMessage() . "\n";
}

?>
