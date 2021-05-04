<?php
   require_once "conn.php";
    $db = pg_connect($connection_string) 
        or die("Errore:<br>". pg_last_error());

    
        $username = $_POST['username'];
        $password = $_POST['password'];
        $hash = get_pwd($username);
			if(!$hash){
				echo "<p> L'utente $username non esiste. <a href=\"login.html\">Riprova</a></p>";
			}
            else{
                if(password_verify($password, $hash)){
                    echo "<p>Login Eseguito con successo</p>";
                    session_start();
                    $_SESSION['username'] = $username;
                    echo "<p><a href=\"logged.php\">Accedi</a> al contenuto riservato solo agli utenti registrati<p>";
                }
                else 
                echo "Username o password errata riprovare il login<br>Effettua il <a href=\"login.html\">login</a>";

            }
?>
<?php
   function get_pwd($user){
   		require "conn.php";
   		//CONNESSIONE AL DB
		$db = pg_connect($connection_string) or die('Impossibile connetersi al database: ' . pg_last_error());
		$sql = "SELECT password FROM login WHERE username=$1;";
		$prep = pg_prepare($db, "sqlPassword", $sql); 
		$ret = pg_execute($db, "sqlPassword", array($user));
		if(!$ret) {
			echo "ERRORE QUERY: " . pg_last_error($db);
			return false; 
		}
		else{
			if ($row = pg_fetch_assoc($ret)){ 
				$pass = $row['password'];
				return $pass;
			}
			else{
				return false;
			}
   		}
   	}	
?>
