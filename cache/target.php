<?php

if (!defined('CURR_DIR'))
	define('CURR_DIR', dirname(__FILE__));

include_once(CURR_DIR.'/db.php');
include_once(CURR_DIR.'/inventory.php');

function target_add($target)
{
	if (db_select_exists("SELECT * FROM targets WHERE id != $target"))
		return false;

	db_insert('targets', array('target'=>$target, 'ingredient'=>$target, 'amount'=>1, 'craft'=>'f'));
	return true;

}

function target_sub_add($target, $ingredient, $amount)
{
	db_insert('targets', array('target'=>$target, 'ingredient'=>$ingredient, 'amount'=>$amount, 'craft'=>'f'));
}

function target_recurse($output, $total)
{
	global $must_get;

	# Do we have the item in sufficient amount ?
	$amount = inventory_is_minimal_amount_met($output, $total);

	# If not, does it have a recipe ?
	if ($amount !== true)
	{
		$arr = db_select_array("SELECT id, json FROM recipes WHERE output = $output");

		# If not, then that's pretty much what you need to get in some other fashion.
		if (empty($arr))
		{
			$must_get[$output] = new stdClass();
			$must_get[$output]->amount = $amount;
			$must_get[$output]->total = $total;
		}
		else
		{
			# We can have many recipes for the same item.
			foreach($arr as $v)
			{
				$ing = json_get_field(json_get_object($v['json']), 'ingredients');

				foreach ($ing as $vv)
				{
					$new_output = json_get_field($vv, 'item_id');
					$new_total = json_get_field($vv, 'count');

					# Just make sure we have a least the item in the database.
					item_add($new_output);

					# Start the process again for an ingredient, only
					# multiply the new total with the old one.
					target_recurse($new_output, $total * $new_total);
				}
			}
		}
	}
}

function target_new($target, $add = true)
{
	global $must_get;

	if ($add && !target_add($target))
		throw new Exception("Target $target already recorded.");

	target_recurse($target, 1);

	foreach ($must_get as $k=>$v)
		target_sub_add($target, $k, $v->total);
}

