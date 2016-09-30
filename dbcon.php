<?php

// Her defineres min database
define("HOSTNAME", "localhost");
define("MYSQLUSER", "root");
define("MYSQLPASS", "");
define("MYSQLDB", "profiler");

// her sker forbindelsen til min database
$connection = new mysqli(HOSTNAME, MYSQLUSER, MYSQLPASS, MYSQLDB);
if ($connection->connect_error) {
die('Connect Error ('. $connection->connect_errno .') ' . $connection->connect_error);
}
$connection->set_charset('utf8');

?>
