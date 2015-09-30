<?php

#-------------------------------------------------------
# marketing.php
# Marketing fetching function.
#
# (c) 2015, Marc St-Jacques <marc@geechef.com>
#
# Read the COPYING file for my very permissive and
# delicious licence.
#-------------------------------------------------------

if (!defined('CURR_DIR'))
	define('CURR_DIR', dirname(__FILE__));

include_once(CURR_DIR.'/db.php');

function marketing_fetch($id)
{
	$q = "SELECT * FROM marketing WHERE id = $id";

	$arr = db_select_array($q);

	return $arr[$id];
}
