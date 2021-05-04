<?php
    require_once "conn.php";
    $db = pg_connect($connection_string)
        or die("impossibile connettersi al db: ". preg_last_error());
?>

<html>
    <body>
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
        <fieldset>
                <legend>REGISTRAZIONE</legend>
                <label>Username: <input type="text" name="username" required /></label>
                <label>Password: <input type="password" name="password" required/></label>
                <label>Password Verification: <input type="password" name="vpass" required/></label>

                <input type="submit" value="REGISTRATI"/>
            </fieldset>
        </form>
    </body>
    <?php
    if(!empty($_POST)){
        if(isset($_POST["username"]))
            $username = $_POST['username'];
        else
            $username = "";
        if(isset($_POST["password"]))
            $password = $_POST['password'];
        else
            $password = "";
        if(isset($_POST["vpass"]))
            $vpass = $_POST['vpass'];
        else
            $vpass = "";
    
        if($password != $vpass)
            echo "le password non coincidono controllare o modificare i campi : <br> Password e Password Verification";
        else{
            if(username_exist($username))
                echo "<p>l'utente $username gia esistente. Riprova</p>";
            else{
                if(insert_utente($username, $password))
					echo "<p> Utente registrato con successo. Effettua il <a href=\"login.html\">login</a></p>";
                else
                    echo "<p>Qualcosa è andato storto riprova</p>";
                
            }

        }
    
    }
    
    ?>
</html>
<?php
function username_exist($user){
	require "conn.php";
	//CONNESSIONE AL DB
	$db = pg_connect($connection_string) or die('Impossibile connetersi al database: ' . pg_last_error());
		//echo "Connessione al database riuscita<br/>"; 
	$sql = "SELECT username FROM login WHERE username=$1";
	$prep = pg_prepare($db, "sqlUsername", $sql); 
	$ret = pg_execute($db, "sqlUsername", array($user));
	if(!$ret) {
		echo "ERRORE QUERY: " . pg_last_error($db);
		return false; 
	}
	else{
		if ($row = pg_fetch_assoc($ret)){ 
			return true;
		}
		else{
			return false;
		}
	}
}

function insert_utente($user, $pass){
	require "conn.php";
	//CONNESSIONE AL DB
	$db = pg_connect($connection_string) or die('Impossibile connetersi al database: ' . pg_last_error());
		//echo "Connessione al database riuscita<br/>"; 
	$hash = password_hash($pass, PASSWORD_DEFAULT);
	$sql = "INSERT INTO login(username, password) VALUES($1, $2)";
	$prep = pg_prepare($db, "insertUser", $sql); 
	$ret = pg_execute($db, "insertUser", array($user, $hash));
	if(!$ret) {
		echo "ERRORE QUERY: " . pg_last_error($db);
		return false; 
	}
	else{
		return true;
	}
}
?>