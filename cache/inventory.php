<?php

if (!defined('CURR_DIR'))
	define('CURR_DIR', dirname(__FILE__));

include_once(CURR_DIR.'/item.php');
include_once(CURR_DIR.'/db.php');
include_once(CURR_DIR.'/json.php');
include_once(CURR_DIR.'/secret/.dbsettings.php');

function inventory_update($id, $amount)
{
	if (!db_update('inventory', array('amount'=>$amount, 'diff'=>"%$amount - amount"), array('id'=>$id)))
			db_insert('inventory', array('id'=>$id, 'amount'=>$amount, 'diff'=>0));

	# As a side effet, add it to the items table.
	item_add($id);
}

function inventory_get_amount($id)
{
	$q = "SELECT * FROM inventory WHERE id = $id";

	$arr = db_select_array_one_field($q, 'amount');

	if (empty($arr))
		return false;

	return $arr[$id];
}

function inventory_is_minimal_amount_met($id, $amount)
{
	$current = inventory_get_amount($id);

	if ($current === false)
		return 0;

	if ($current < $amount)
		return $current;

	return true;
}

?>
