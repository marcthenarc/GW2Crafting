<?php

#-------------------------------------------------------
# db.php
# Database connectivity and calls.
#
# (c) 2015, Marc St-Jacques <marc@geechef.com>
#
# Read the COPYING file for my very permissive and
# delicious licence.
#-------------------------------------------------------

if (!defined('CURR_DIR'))
	define('CURR_DIR', dirname(__FILE__));

include_once(CURR_DIR.'/json.php');
include_once(CURR_DIR.'/secret/.dbsettings.php');

$cx = false;

# Connect to database. You can call this function as often
# as you like but it will work only once.
function db_connect()
{
	global $cx;

	# Not connected yet ?
	if ($cx === false)
	{
		$cx = pg_connect(sprintf("host=%s dbname=%s user=%s password=%s", DB_HOST, DB_NAME, DB_USER, DB_PASS));

		# Still not connected ?
		if ($cx === false)
			throw new Exception('Could not connect to the database.');
	}
}

# Simple query call if you want to write a complete query and run it.
function db_query($q)
{
	# Initiate connection.
	db_connect();

	$res = pg_query($q);

	if ($res === false)
		throw new Exception("Query failed");

	return $res;
}

# Pass a SELECT query and return whether or not their are matching values.
# Input: $q = the SELECT query.
# Returns : TRUE if query matches any rows, FALSE otherwise.
function db_select_exists($q)
{
	return (pg_num_rows(db_query($q)) != 0);
}

# Select multiple rows and return an array of all matching rows.
# The id field and a least another field must be present in the query. 
# You can set a limit of rows to retrieve if you haven't embeded
# the keyword LIMIT into you code.
# Input : $q = the SELECT query.
# Input : $limit = number of rows to return.
# Returns: a array of rows with the id field as key.
function db_select_array($q, $limit = -1)
{
	$res = db_query($q);

	$num = pg_num_rows($res);

	if ($limit > 1 && $limit < $num)
		$num = $limit;

	$arr = array();

	for ($i=0; $i<$num; $i++)
	{
		$row = pg_fetch_assoc($res);

		if ($row === false)
			throw new Exception("Failed to fetch a row");

		if (!isset($row['id']))
			throw new Exception("The 'id' field must be part of the query.");

		$id = $row['id'];
		unset($row['id']);

		$arr[$id] = $row;
	}

	return $arr;
}

# Select multiple rows and return an array of all matching rows.
# The id field and a least another field must be present in the query. 
# You can set a limit of rows to retrieve if you haven't embeded
# the keyword LIMIT into you code.
# Input : $q = the SELECT query.
# Input : $field = the specific field to keep as value.
# Input : $limit = number of rows to return.
# Returns: a array of values with the id field as key.
function db_select_array_one_field($q, $field, $limit = -1)
{
	$arr = db_select_array($q, $limit);

	$ret = array();

	foreach ($arr as $k=>$v)
	{
		if (!isset($v[$field]))
			throw new Exception("Field '$field' doesn't exists in results.");

		$ret[$k] = $v[$field];
	}

	return $ret;
}

# INSERT data into the database.
# Input : $table = the table to insert data.
# Input : $data = an array of key=>value pairs matching the table fields.
# Returns : the numbers of rows affected by this query.
function db_insert($table, $data)
{
	$f = '';
	$x = '';

	foreach ($data as $k=>$v)
	{
		if (!empty($f))
			$f .= ',';

		$f .= $k;

		if (!empty($x))
			$x .= ',';

		$x .= sprintf("'%s'", str_replace("'", "''", $v));
	}

	$q = sprintf("INSERT INTO $table ($f) VALUES ($x)");
	
	return pg_affected_rows(pg_query($q));
}

# UPDATE data in database.
# Input : $table = the table to insert data.
# Input : $data = a key=>value pair on data to update.
# Input : $cond = a key=>value pair of conditions to meet in order to update;
# Returns : the numbers of rows affected by this query.
function db_update($table, $data, $cond)
{
	$d = '';
	$c = '';

	foreach ($data as $k=>$v)
	{
		if (!empty($d))
			$d .= ',';

		$d .= sprintf("%s='%s'", $k, str_replace("'", "''", $v));
	}

	foreach ($cond as $k=>$v)
	{
		if (!empty($c))
			$c .= ' AND ';

		$c .= sprintf("%s='%s'", $k, str_replace("'", "''", $v));
	}

	$q = sprintf("UPDATE $table SET $d WHERE $c"); 
	
	return pg_affected_rows(pg_query($q));
}

# DELETE data in the database.
# Input : $table = the table from which to delete data.
# Input : $cond = a key=>value pair of conditions to meet in order to delete;
# Returns : the numbers of rows affected by this query.
function db_delete($table, $cond)
{
	$d = '';
	$c = '';

	foreach ($cond as $k=>$v)
	{
		if (!empty($c))
			$c .= ' AND ';

		$c .= sprintf("%s='%s'", $k, str_replace("'", "''", $v));
	}

	$q = sprintf("DELETE FROM $table WHERE $c");
	
	return pg_affected_rows(pg_query($q));
}

