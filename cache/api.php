<?php

#-------------------------------------------------------
# api.php
# Calls to the GW2 API.
#
# (c) 2015, Marc St-Jacques <marc@geechef.com>
#
# Read the COPYING file for my very permissive and
# delicious licence.
#-------------------------------------------------------

if (!defined('CURR_DIR'))
	define('CURR_DIR', dirname(__FILE__));

define('API2', 'https://api.guildwars2.com/v2/');

include_once(CURR_DIR.'/json.php');

# Get the user's API key from disk.
function api_get_key()
{
	return '?access_token=' . trim(file_get_contents(CURR_DIR . '/secret/.key'));
}

# Send an API call to the site and return the response.
# Input: a URL
# Returns: a json string.
function api_get_url($url)
{
	$contents = @file_get_contents($url);

	if ($contents === false)
		throw new Exception("Could not get content for site or wrong URL.");

	return $contents;
}

# Get all characters names from the user's account. Returns an array.
# Returns: a json string.
function api_get_characters()
{
	return api_get_url(API2 . 'characters' . api_get_key());
}

# Get a specific character from the user's account.
# Input: The character's name
# Returns a json string.
function api_get_specific_character($name)
{
	return api_get_url(API2 . 'characters/' . rawurlencode($name). api_get_key());
}

?>
