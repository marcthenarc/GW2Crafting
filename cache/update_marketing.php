<?php

#-------------------------------------------------------
# update_marketing.php
# Transform notable information into useful
# facts on the overlay.
#
# (c) 2015, Marc St-Jacques <marc@geechef.com>
#
# Read the COPYING file for my very permissive and
# delicious licence.
#-------------------------------------------------------

if (!defined('CURR_DIR'))
	define('CURR_DIR', dirname(__FILE__));

include_once(CURR_DIR.'/inventory.php');
include_once(CURR_DIR.'/item.php');
include_once(CURR_DIR.'/api.php');
include_once(CURR_DIR.'/db.php');
include_once(CURR_DIR.'/json.php');
include_once(CURR_DIR.'/secret/.dbsettings.php');

function marketing_add($type, $index)
{
	db_insert('marketing', array('type'=>$type, 'index'=>$index));
}

function marketing_clear()
{
	db_query("TRUNCATE marketing; SELECT setval('marketing_id_seq', 1, false)");
}

function marketing_add_world()
{
	$arr = db_select_array('SELECT * FROM characters');

	if (empty($arr))
		return;

	foreach ($arr as $k=>$v)
		db_insert('marketing', array('type'=>'world', 'index'=>$k));
}

function marketing_add_inventory()
{
	$arr = inventory_has_diff();

	if (empty($arr))
		return;

	foreach ($arr as $k=>$v)
		db_insert('marketing', array('type'=>'inventory', 'index'=>$k));
}

function marketing_add_targets()
{
	$arr = db_select_array('SELECT * FROM targets');

	if (empty($arr))
		return;

	foreach ($arr as $k=>$v)
		db_insert('marketing', array('type'=>'targets', 'index'=>$k));
}

try
{
	marketing_clear();
	marketing_add_world();
	marketing_add_inventory();
	marketing_add_targets();
}
catch (Exception $e)
{
	echo $e->getMessage() . "\n";
}

