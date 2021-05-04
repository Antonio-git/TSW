<!doctype html>
<?php 
require_once "../logindb.php";

if(!empty($_POST) && $_POST['add']){
	$db = pg_connect($connection_string)
			  or die("Impossibile connetersi al DB" . pg_last_error());
	$cognome = $_POST['cognome'];
	$nome = $_POST['nome'];
	$numero = $_POST['numero'];
	$email = $_POST['email'];
	
	$array = array($cognome,$nome,$numero,$email);
	
	$stmtname = "InsertContatto";
	
	$sql_ins = "INSERT INTO contatti(cognome, nome, numero, email) 
				VALUES($1, $2, $3, $4)";
	$ret = pg_prepare($db,$stmtname,$sql_ins);
		if(!$ret)
			echo "Errore: ". pg_last_error($db);
		else{
			$ret = pg_execute($db,$stmtname,$array);
			if(!$ret)
				echo "Errore: ". pg_last_error($db);
			else
				echo "Utente $nome $cognome aggiunto ai contatti<br><a href=\"rubrica.php\">torna ai contatti</a>";
			
		}
}

?>

<html>
<head>
<meta charset="utf-8">
<title>NUOVO CONTATTO</title>
</head>

<body>
	<fieldset>
		<form target="nuovo_contatto.php" method="post">
			<p>
				<label for="cognome">Cognome <input type="input" name="cognome" id="cognome" required /></label>
			</p>

			<p>
				<label for="nome">Nome <input type="input" name="nome" id="nome" required/></label>
			</p>

			<p>
				<label for="numero">Numero <input type="input" name="numero" id="numero" required/></label>
			</p>
			<p>
				<label for="email">E-Mail <input type="input" name="email" id="email" /></label>
			</p>
				<input type="submit" name="add" value="AGGIUNGI CONTATTO"/>
				&nbsp;
				<input type="reset" />
			</p>
		</form>

		<p><a href="rubrica.php">Torna ai contatti</a></p>
	
	</fieldset>

	<a href="contatti.html" ><h2>HOME</h2></a>
</body>
</html>