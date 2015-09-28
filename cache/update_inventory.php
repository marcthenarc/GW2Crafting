<?php

#-------------------------------------------------------
# update_inventory.php
# Inventory retrieving ands storing.
#
# (c) 2015, Marc St-Jacques <marc@geechef.com>
#
# Read the COPYING file for my very permissive and
# delicious licence.
#-------------------------------------------------------

if (!defined('CURR_DIR'))
	define('CURR_DIR', dirname(__FILE__));

include_once(CURR_DIR.'/item.php');
include_once(CURR_DIR.'/api.php');
include_once(CURR_DIR.'/db.php');
include_once(CURR_DIR.'/json.php');
include_once(CURR_DIR.'/secret/.dbsettings.php');

$total = array();

# Add item and amount to the global total.
function inventory_add_to_total($id, $amount)
{
	global $total;

	if (isset($total[$id]))
		$total[$id] += $amount;
	else
		$total[$id] = $amount;
}

try
{
	# Get items from the bank
	$arr = json_get_object(api_get_bank());
	
	foreach ($arr as $v)
	{
		if (is_object($v))
			inventory_add_to_total($v->{'id'}, $v->{'count'});
	}

	# Get iteams from the materials panel.
	$arr = json_get_object(api_get_materials());

	foreach ($arr as $v)
	{
		if (is_object($v))
			inventory_add_to_total($v->{'id'}, $v->{'count'});
	}

	# Get items from every bag owned by every character.
	$arr = db_select_array('SELECT id, json, name FROM characters ORDER BY id');

	# For each character ...
	foreach ($arr as $c)
	{
		$bags = json_get_field(json_get_object($c['json']), 'bags');

		# For each bag ...
		foreach ($bags as $k=>$v)
		{
			if (is_object($v))
			{
				$inv = json_get_field($v, 'inventory');

				# Fr each inventory item in bag ...
				foreach ($inv as $vv)
				{
					if (is_object($vv))
						inventory_add_to_total($vv->{'id'}, $vv->{'count'});
				}
			}
		}
	}

	# Take everything and add them to the inventory table, then the items table.
	foreach ($total as $k=>$v)
	{
		if (!db_update('inventory', array('amount'=>$v, 'diff'=>"%$v - amount"), array('id'=>$k)))
			db_insert('inventory', array('id'=>$k, 'amount'=>$v, 'diff'=>0));

		item_add($k);
	}
}
catch (Exception $e)
{
	echo $e->getMessage();
}

?>
