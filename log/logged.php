<html>
    <body>
        <?php
        session_start();
        if(empty($_SESSION['username']))
            echo "Effettuare il <a href=\"login.html\">Login</a> oppure <a href=\"registrati.php\">Registrati</a> per accede al contenuto";
        else{
                $user = $_SESSION['username'];
                $str = strtoupper($user);
              echo "<h1>Benvenuto $str! </h1>";
    
            
        ?>
        <img src="https://media.giphy.com/media/eJFWFRCD0Bfl8jqabR/giphy.gif"/>
        <p>
			<a href="logout.php">Logout</a>
		</p>
        <?php } ?>
    
    </body>
<html>