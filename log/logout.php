<html>
    <body>
    <img src="https://media.giphy.com/media/UoYA5jnXE5V7u4MJh7/giphy.gif"/>
        <?php 
        session_start();
        $user = $_SESSION["username"];
        destroy_session_and_data();
        echo "<p> Logout effettuato. Ciao ".$user." </p>"
        ?>
	<p>Torna alla <a href=login.html>Home</a></p>
    </body>
</html>




<?php
function destroy_session_and_data()
{
   
    $_SESSION = array();  //UNSET DI TUTTE LE VARIABILI DI SESSIONE
    if (session_id() != "" ||  isset($_COOKIE[session_name()])) 
	//CANCELLA IL COOKIE CHE MEMORIZZA l'ID della sessione sul 	client
	setcookie(session_name(), '', time() -    2592000, '/'); 	    /* 3) */ 	
	session_destroy(); //DISTRUGGE LA SESSIONE
}
?>