<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>CREATE TABLE</title>
</head>

<body>
	<?php require_once "../logindb.php";
	$db = pg_connect($connection_string)
		or die("Impossibile connetersi al DB" . pg_last_error());
	$sql = "DROP TABLE IF EXISTS contatti cascade;
			CREATE TABLE contatti(
			id serial PRIMARY KEY,
			cognome varchar(30),
			nome varchar(30),
			numero varchar(15),
			email varchar(30))";
	
	$ret = pg_query($db,$sql);
	if(!$ret)
		echo "Errore creazione tabella".pg_last_error();
	else
		echo "<h1>TABELLA CREATA</h1>"
	?>
	
</body>
</html>