<?php

#-------------------------------------------------------
# add_target.php
# Add a target to craft.
#
# (c) 2015, Marc St-Jacques <marc@geechef.com>
#
# Read the COPYING file for my very permissive and
# delicious licence.
#-------------------------------------------------------

if (!defined('CURR_DIR'))
	define('CURR_DIR', dirname(__FILE__));

include_once(CURR_DIR.'/target.php');

if (!isset($argv[1]) || !is_numeric($argv[1]))
	die ("Usage: php add_target.php <id>\n");

try
{
	target_new($argv[1]);
}
catch(Exception $e)
{
	echo $e->getMessage() . "\n";
}

?>
