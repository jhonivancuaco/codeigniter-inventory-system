<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;

/**
 * -------------------------------------------------------------------
 * DATABASE CONNECTIVITY SETTINGS
 * -------------------------------------------------------------------
 *
 * This file will contain the settings needed to access your database.
 *
 * For complete instructions please consult the 'Database Connection'
 * page of the User Guide.
 *
 * -------------------------------------------------------------------
 * EXPLANATION OF VARIABLES
 * -------------------------------------------------------------------
 *
 *	['dsn']      The full DSN string describe a connection to the database.
 *	['hostname'] The hostname of your database server.
 *	['username'] The username used to connect to the database
 *	['password'] The password used to connect to the database
 *	['database'] The name of the database you want to connect to
 *	['dbdriver'] The database driver. e.g.: mysqli.
 *			Currently supported:
 *				 cubrid, ibase, mssql, mysql, mysqli, oci8,
 *				 odbc, pdo, postgre, sqlite, sqlite3, sqlsrv
 *	['dbprefix'] You can add an optional prefix, which will be added
 *				 to the table name when using the  Query Builder class
 *	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
 *	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
 *	['cache_on'] TRUE/FALSE - Enables/disables query caching
 */

$db['default'] = array(
	'dsn'	=> '',
	'hostname' => 'localhost',
	'username' => 'root',
	'password' => 'root',
	'database' => 'inventory',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT === 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);

