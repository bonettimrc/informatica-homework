<?php
	// Crea una nuova sessione o recupera quella precedente
	session_start(['use_strict_mode' => true]);

	// Se l'utente si disconnette...
	if (isset($_POST["btnReset"]) == true)
	{
		// Viene interrotta la sessione corrente
		session_destroy();
	
		// Viene inizializzata una nuova sessione
		session_start(['use_strict_mode' => true]);
	}
	
	// Verifica la presenza della variabile contatore
	if (isset($_SESSION["contatore"]) == false)
		$_SESSION["contatore"] = 0;
	
	// Incrementa la variabile contatore
	if (isset($_POST["btnIncrementa"]) == true)
		$_SESSION["contatore"]++;
?>

<html>
	<head>
		<title>13.session</title>
	</head>
	
	<body>
		<form method="POST">
			<input type="submit" name="btnIncrementa" value="Incrementa">
			<input type="submit" name="btnReset" value="reset">
		</form>
		
		<?php
			// Visualizza il valore del contatore
			echo "Contatore: ".$_SESSION["contatore"]."<br>";
			
			// Visualizza l'ID di sessione
			echo session_id();	
			echo "<br>";
			
			// Visualizziamo tutti i cookies presenti
			foreach($_COOKIE as $k => $v)
			{
				echo "$k : $v<br>";
			}
						
			
		?>
	</body>
	
</html>