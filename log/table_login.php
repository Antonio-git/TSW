<?php 
	require_once "conn.php";
	$db = pg_connect($connection_string) or die('Impossibile connetersi al database: ' . pg_last_error());
		$sql =  "DROP TABLE IF EXISTS login cascade;
	 		CREATE TABLE login(
			username varchar(30) PRIMARY KEY,
			password varchar(255),
			email varchar(30))";
	$ret = pg_query($db,$sql);
	if(!$ret)
		echo "ERRORE :". pg_last_error($db);

?>