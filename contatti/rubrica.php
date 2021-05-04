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
<title>RUBRICA</title>
</head>

<body>
	<h1>Contatti</h1>
	<?php
			$sql = "SELECT * FROM contatti";
			$ret = pg_query($db,$sql);
			if(!$ret)
				echo "Errore :". pg_last_error();
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
				echo '<td><a href="modifica_contatto.php?id='.$id.'">Modifica</a> <a href="'.$_SERVER['PHP_SELF'].'?action=delete&id='.$id.'">Cancella</a></td>';
				echo "</tr>";
						  }
		?>
	</table>
	<p>
				<a href="nuovo_conattto.php">Nuovo contatto</a>
			</p>
	<a href="contatti.html" ><h2>HOME</h2></a>
	
</body>
</html>