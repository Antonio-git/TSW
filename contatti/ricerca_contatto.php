<!doctype html>
<?php require_once "../logindb.php";
$db = pg_connect($connection_string)
		or die("Impossibile connetersi al DB" . pg_last_error());
?>
<?php 
		if(!empty($_GET['action']) && $_GET['action']=='delete'){
			$id=$_GET['id'];
			$sql_byId = "SELECT id, nome, cognome, numero, email FROM contatti WHERE id=$1;";
			$prep = pg_prepare($db, 'selectById', $sql_byId); 
			if(!$prep) 
				echo "ERRORE QUERY DELETE: " . pg_last_error($db);
			else{
				$ret_delete = pg_execute($db, 'selectById', array($id));
				if(!$ret_delete)
					echo "ERRORE: ". pg_last_error($db);
				else{
					$utente = pg_fetch_array($ret_delete);
					if(!$utente)
						echo "L'utente che si intende cancellare non esiste";
					else{
						$nome = $utente['nome'];
						$cognome = $utente['cognome'];
						$sql_delete = "DELETE FROM contatti WHERE id=$1";
						$prep_delete = pg_prepare($db, "deleteById",$sql_delete);
						$ret_delete = pg_execute($db, 'deleteById', array($id));
						if(!$ret_delete){
							echo "ERRORE DELETE " . pg_last_error($db);
						}
						else{
							echo "<p> L'utente $nome $cognome è stato cancellato.";
						}
					}
				}
			}
		
		}
		
				?>

<html>
<head>
<meta charset="utf-8">
<title>Documento senza titolo</title>
</head>

<body>
	<fieldset>
		<legend>RICERCA</legend>
		<form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
	
		<p>
				<label for="cognome">Cognome <input type="input" name="cognome" id="cognome" placeholder="Insert Cognome"/></label>
			</p>

			<p>
				<label for="nome">Nome <input type="input" name="nome" id="nome" placeholder="Insert Nome" /></label>
			</p>

			<p>
				<label for="numero">Numero <input type="input" name="numero" id="numero" placeholder="Insert Numero"/></label>
			</p>
			<p>
				<label for="email">E-Mail <input type="input" name="email" id="email" placeholder"Insert Email"/></label>
			</p>
			<br>
			<input type="submit" value="ricerca"/>
	</form>
	</fieldset>
	
	<h1>Contatti</h1>
	<?php
		if(!empty($_POST)){
			if(!empty($_POST['cognome'])){
				$cognome = $_POST['cognome'];
				$sql = "SELECT * FROM contatti WHERE cognome LIKE '%$cognome%'";
			}
			elseif(!empty($_POST['nome'])){
				$nome = $_POST['nome'];
				$sql = "SELECT * FROM contatti WHERE nome LIKE '%$nome%'";
			}elseif(!empty($_POST['numero'])){
				$numero = $_POST['numero'];
				$sql = "SELECT * FROM contatti WHERE numero LIKE '%$numero%'";
			}
			else{
				$email = $_POST['email'];
				$sql = "SELECT * FROM contatti WHERE email LIKE '%$email%'";
		
			}			
			$ret = pg_query($db,$sql);
			if(!$ret)
				echo "Errore :". pg_last_error();
		}
	?>
	<table border="true">
			<tr>
				<th>Cognome</th> 
				<th>Nome</th>
				<th>Telefono</th>
				<th>E-mail</th>
				<th>Azioni</th>
			</tr>
		<?php 
			if(!empty($_POST)){
			 	while($row = pg_fetch_assoc($ret)){
					$nome = $row["nome"];
					$cognome = $row["cognome"];
					$numero = $row["numero"];
					$email = $row["email"];
					$id = $row["id"];
					echo "<tr>";
					echo "<td>$cognome</td>";
					echo "<td>$nome</td>";
					echo "<td>$numero</td>";
					echo "<td>$email</td>";
					echo '<td><a href="modifica_contatto.php?id='.$id.'">Modifica</a> <a href="'.$_SERVER['PHP_SELF'].'?	action=delete&id='.$id.'">Cancella</a></td>';
					echo "</tr>";
				}
			}
		?>
	</table>
	<a href="rubrica.php"><h2>Lista contatti</h2></a>
	<a href="nuovo_conattto.php" ><h2>Nuovo Contatto</h2></a>
	<a href="contatti.html" ><h2>HOME</h2></a>
</body>
</html>