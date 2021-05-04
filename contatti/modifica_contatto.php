<!doctype html>
<?php require_once "../logindb.php";
	  $db = pg_connect($connection_string)
			  or die("Impossibile connetersi al DB" . pg_last_error());
		if(!empty($_GET['id'])){
			$id = $_GET['id'];
			$sql = "SELECT * FROM contatti WHERE id=$1";
				$prep = pg_prepare($db,'selectById',$sql);
				if(!$prep)
					echo "Errore: ". pg_last_error($db);
				else{
					$ret_select = pg_execute($db,'selectById',array($id));
					if(!$ret_select)
						echo "Errore: ". pg_last_error($db);
					else{
						$utente = pg_fetch_array($ret_select);
						if(!$utente)
							echo "L'utente che si intende modificare non esiste";
						else{
							$nome = $utente['nome'];
							$cognome = $utente["cognome"];
							$numero = $utente["numero"];
							$email = $utente["email"];
						}
					}
				}
			
		}
		if(!empty($_POST) && !empty($_POST['id']) ){
			
			$id = $_POST['id'];
			$nome = $_POST['nome'];
			$cognome =$_POST['cognome'];
			$numero =$_POST['numero'];
			$email =$_POST['email'];
			$array = array($nome,$cognome,$numero,$email,$id);
			$sql_update = <<<_QUERY
									UPDATE contatti
									SET
									nome = $1,
									cognome = $2,
									numero = $3,
									email = $4
									WHERE id = $5;
								_QUERY;
			$prep = pg_prepare($db,'UpdateUtenti',$sql_update);
			if(!$prep)
				echo 'ERRORE : '. pg_last_error($db);
			else{
				$ret_up = pg_execute($db,'UpdateUtenti',$array);
				if(!$ret_up){
					echo "ERRORE AGGIORNAMETO. RICARICARE LA PAGINA E RIPROVARE - " .pg_last_error($db);
				}
				else{
					echo "Aggiornamento riuscito per il contatto $nome $cognome";
				}
			}
			
		}

?>
<html>
<head>
<meta charset="utf-8">
<title>MODIFICA CONTATTO</title>
</head>

<body>
</body>
	<fieldset>
	<form target="modifica_contatto.php" method="post">
			<p>
				<label for="cognome">Cognome <input type="input" name="cognome" id="cognome" value="<?php echo $cognome ?>"/></label>
			</p>

			<p>
				<label for="nome">Nome <input type="input" name="nome" id="nome" value="<?php echo $nome ?>"/></label>
			</p>

			<p>
				<label for="numero">Numero <input type="input" name="numero" id="numero" value="<?php echo $numero ?>"/></label>
			</p>
			<p>
				<label for="email">E-Mail <input type="input" name="email" id="email" value="<?php echo $email ?>"/></label>
			</p>
			<input type="hidden" name="id" value="<?php echo $id ?>"/>
			<p>
				<input type="submit" name="add" value="Modifica"/>
			</p>
		</form>
		<p><a href="rubrica.php">Torna ai contatti</a></p>
		
		</fieldset>
	<a href="contatti.html" ><h2>HOME</h2></a>
</html>