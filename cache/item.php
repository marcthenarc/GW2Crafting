<?php

#-------------------------------------------------------
# item.php
# Item management.
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
include_once(CURR_DIR.'/json.php');
include_once(CURR_DIR.'/secret/.dbsettings.php');

# Add an item to the database and add the corresponding icon
# in the icons' cache folder.
# Input: the item's API id number.
# Returns : nothing but exceptions will the raised if problems arise.
function item_add($id)
{
	# Forward declare so that we can reuse the API call to the item if necessary,
	# because I would like to check the icon cache independently.
	$json_en = '';

	# Check if item exists in the database.
	if (!db_select_exists("SELECT id FROM items WHERE id = $id"))
	{
		# Get data in both languages.
		$json_en = api_get_item($id, 'EN');
		$json_fr = api_get_item($id, 'FR');

		# Extract the names
		$name_en = json_get_field(json_get_object($json_en), 'name');
		$name_fr = json_get_field(json_get_object($json_fr), 'name');

		db_insert('items', array('id'=>$id, 'json'=>$json_en, 'name_en'=>$name_en, 'name_fr'=>$name_fr));
	}

	$fn = CURR_DIR . "/icons/$id.png";

	# Now let's check the icon cache.
	if (file_exists($fn) === false)
	{
		if (empty($json_en))
			$json_en = api_get_item($id, 'EN');

		$icon = api_get_url(json_get_field(json_get_object($json_en), 'icon'));

		if (file_put_contents($fn, $icon) === false)
			throw new Exception("Could not write icon data.");
	}
}

?>
