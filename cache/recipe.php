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

include_once(CURR_DIR.'/item.php');
include_once(CURR_DIR.'/api.php');
include_once(CURR_DIR.'/db.php');
include_once(CURR_DIR.'/json.php');
include_once(CURR_DIR.'/secret/.dbsettings.php');

# Extract ingredients from a recipe and add them as items
# in the database.
# Input: $id = the recipe's API id number.
# Returns, nothing.
function recipe_extract_ingredients($id)
{
	# Just in case.
	recipe_add($id);

	# Fetch recipe
	$arr = db_select_array("SELECT * from recipes WHERE id = $id");

	$output = $arr[$id]['output'];
	$ing = json_get_field(json_get_object($arr[$id]['json']), 'ingredients');

	foreach ($ing as $i)
		item_add($i->{'item_id'});
}

# Add a recipe to the database and add corresponding items
# in the items table.
# Input: $id = the recipe's API id number.
# Returns : nothing, but exceptions will the raised if problems arise.
function recipe_add($id)
{
	if (!db_select_exists("SELECT id FROM recipes WHERE id = $id"))
	{
		$json = api_get_specific_recipe($id);
		$output = json_get_field(json_get_object($json), 'output_item_id');

		db_insert('recipes', array('id'=>$id, 'json'=>$json, 'output'=>$output));
	}
}

?>
