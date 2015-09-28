<?php

#-------------------------------------------------------
# recipe.php
# Recipe management.
#
# (c) 2015, Marc St-Jacques <marc@geechef.com>
#
# Read the COPYING file for my very permissive and
# delicious licence.
#-------------------------------------------------------

if (!defined('CURR_DIR'))
	define('CURR_DIR', dirname(__FILE__));

include_once(CURR_DIR.'/recipe.php');
include_once(CURR_DIR.'/api.php');
include_once(CURR_DIR.'/json.php');

try
{
	$arr = json_get_object(api_get_recipes());

	foreach ($arr as $v)
		recipe_add($v);
}
catch (Exception $e)
{
	echo $e->getMessage();
}

?>
