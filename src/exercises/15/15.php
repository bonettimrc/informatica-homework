<?php
	session_start(['use_strict_mode' => true]);
	
	// Percorso del file utilizzato per la memorizzazione degli elementi
	$storage = "";
	
	// Se TRUE l'utente è loggato	
	$loggedin = false;
	
	// --------------------------------------
	// => L'utente ha richiesto il logout
	if (isset($_POST["logout"]) == true)
	{
		session_destroy();
		
		session_start(['use_strict_mode' => true]);
	}

	// --------------------------------------
	// => L'utente ha eseguito il login
	if (isset($_POST["login"]))
	{
		// Memorizza il suo nome
		$_SESSION["username"] = $_POST["username"];
		
		// Imposta il percorso del file da utilizzare
		$storage = $_SESSION["username"].".txt";

		// Caricamento dei contenuti precedenti
		// Deserializza il contenuto del file ottenendo un'istanza array
		if (file_exists($storage) == true)
			$_SESSION["contenuto"] = unserialize(file_get_contents($storage));
		else
			$_SESSION["contenuto"] = array();
	}
	// Verifica sessione attiva: utente loggato
	if (isset($_SESSION["username"]) == true)
	{
		$loggedin = true;

		// Imposta il percorso del file da utilizzare
		$storage = $_SESSION["username"].".txt";
	}	
	
	// --------------------------------------
	// => L'utente ha richiesto il salvataggio
	if (isset($_POST["save"]) == true)
	{
		// Aggiorniamo il contenuto del file utilizzato per lo storage
		file_put_contents($storage, serialize($_SESSION["contenuto"]));
	}

	// --------------------------------------
	// => Se è stato richiesto il reset...	
	if (isset($_POST["reset"]))
	{
		// Se la cartella uploads è presente...
		if (file_exists("magazzino/".$_SESSION["username"]))
		{
			// Ottiene l'elenco dei file presenti in cartella
			$files = scandir("magazzino/".$_SESSION["username"]);
			
			// Elimina tutti i file
			foreach($files as $file)
			{
				if (is_file("magazzino/".$_SESSION["username"]."/".$file))
					unlink("magazzino/".$_SESSION["username"]."/".$file);
			}
		}
		
		// Elimina il file utilizzato per lo storage
		if (file_exists($storage))
			unlink($storage);
			
		// Azzeramento elenco prodotti
		$_SESSION["contenuto"] = array();	
	}

	// --------------------------------------
	// Se è stato inviato qualcosa...
	if (isset($_POST["invia"]))
	{
		// Se la cartella non esiste...
		if (file_exists("magazzino/".$_SESSION["username"]) == false)
			mkdir("magazzino/".$_SESSION["username"]);	// crea la cartella
		
		// Definisce il percorso relativo del file
		$percorso = "magazzino/".$_SESSION["username"]."/".$_FILES["miniatura"]["name"];
		
		// Sposta il file caricato
		move_uploaded_file(
			$_FILES["miniatura"]["tmp_name"],		  //temp
			"magazzino/".$_SESSION["username"]."/".$_FILES["miniatura"]["name"]); //nome.ext
			
		// Determinazione indice elemento
		$newIndex = count($_SESSION["contenuto"]);
		
		for($p=0; $p<count($_SESSION["contenuto"]); $p++)
		{
			if ($_SESSION["contenuto"][$p]["Modello"] == $_POST["modello"])
			{
				$newIndex = $p;
				break;
			}
		}
		
		// Array associativo (indici testuali)
		$_SESSION["contenuto"][$newIndex] = array(
			"Percorso" => $percorso, 
			"Categoria" => $_POST["categoria"],
			"Modello" => $_POST["modello"],
			"Descrizione" => $_POST["descrizione"],
			"Quantita" => $_POST["quantita"],
			"PrezzoUnitario" => $_POST["prezzoUnitario"]
		);			
	}
	
	// Valore commerciale dei prodotti visualizzati
	$valoreCommerciale = 0;
	
	// Elenco categorie univoche
	$categorie = array();
	
	// Categoria selezionata
	$filtro = "Qualsiasi";
	
	// Verifica se l'utente ha selezionato una categoria
	if (isset($_POST["filtro"]))
		$filtro = $_POST["filtro"];
	
	// Operazione varie...
	if ($loggedin == true)
	{
		foreach($_SESSION["contenuto"] as $item)
		{
			// Determinazione esistenza categoria prodotto corrente
			// in elenco categorie
			$trovato = false;
			foreach($categorie as $cat)
			{
				// Categoria uguale a quella del prodotto corrente?
				if ($cat == $item["Categoria"])
					$trovato = true;
			}
			// Se la categoria non è presente la aggiunge
			if ($trovato == false)
				$categorie[count($categorie)] = $item["Categoria"];
			
			// Determinazione valore commerciale per la categoria selezionata
			if ($filtro == $item["Categoria"] || $filtro == "Qualsiasi")
				$valoreCommerciale += 
					$item["Quantita"] * $item["PrezzoUnitario"];
		}
	}
	
?>

<html>
	<head>
		<title>Magazzino</title>
		
		<!-- inclusione libreria jQuery -->
		<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
		
		<!-- implementazione Javascript -->
		<script>
			
			$(document).ready(function()
				{
					// Invia automaticamente la form su 
					// cambiamento della selezione
					$("select[name=filtro]").change(function()
						{
							$("form[name=FormFiltro]").submit();
						});
				});
			
		</script>		
		
		<style>
			#login
			{
				display: <?php echo ($loggedin == false)? "block" : "none"; ?>;
			}
			#logout
			{
				display: <?php echo ($loggedin == true)? "block" : "none"; ?>;
			}
			#contents
			{
				display: <?php echo ($loggedin == true)? "block" : "none"; ?>;
			}
		</style>		
	</head>
	
	<body>
		<h3>Gestione Magazzino</h3>
		
		<!-- FORM di LOGIN -->
		<div id="login">
			<form method="POST">
				<input type="text" name="username">
				<input type="submit" name="login" value="Login">
			</form>
		</div>
		
		<!-- FORM di LOGOUT -->
		<div id="logout">
			<?php
				if (isset($_SESSION["username"]))
					echo "<h1>".$_SESSION["username"]."</h1>"; 	
			?>
			
			<form method="POST">
				<input type="submit" name="logout" value="Logout">
				<input type="submit" name="save" value="Salva mdifiche">
			</form>
		</div>

		<!-- GESTIONE CONTENUTI -->
		<div id="contents">
			<form method="POST" enctype="multipart/form-data">
				<label>Modello</label><br>
				<input type="text" name="modello"><br>
				
				<label>Categoria</label><br>
				<input type="text" name="categoria"><br>
				
				<label>Quantit&agrave;</label><br>
				<input type="number" name="quantita"><br>
	
				<label>Prezzo Unitario</label><br>
				<input type="number" name="prezzoUnitario"><br>
	
				<label>Descrizione estesa</label><br>
				<textarea name="descrizione"></textarea><br>
	
				<label>Miniatura</label><br>
				<input type="file" name="miniatura"><br><br>
				
				<input type="hidden" name="filtro" value="<?php echo $filtro; ?>">
				
				<input type="submit" name="invia" value="invia">
				<input type="submit" name="reset" value="reset">
			</form>
			
			<hr> <!-- ----------------------- -->
			
			<table style="width:100%;">
				<tr>
					<td>
						Filtra per categoria
						<form name="FormFiltro" method="POST">
							<select name="filtro">
								<option>Qualsiasi</option>
								
								<?php
									// Riempie la lista con le categorie uniche
									foreach($categorie as $cat)
									{
										if ($cat == $filtro)
											echo "<option selected>$cat</option>";
										else
											echo "<option>$cat</option>";								
									}	
								?>						
							</select>
						</form>
					</td>
					
					<td style="text-align:right;">
						Valore commerciale complessivo:
						<?php echo $valoreCommerciale; ?>
					</td>
				</tr>			
			</table>
			
			<hr> <!-- ----------------------- -->
			
			<table>
				<?php
					
					// Scorre tutto il contenuto dell'array
					if (count($_SESSION["contenuto"]) > 0)
					{
						foreach($_SESSION["contenuto"] as $row)
						{
							// Array Associativo
							// Scrive la singola riga della tabella
							if ($row["Categoria"] == $filtro ||
								$filtro == "Qualsiasi")
							{
								echo "<tr>";
								echo "<td><img style=\"width:150px;\" src=\"".$row["Percorso"]."\"></td>";
								echo "<td>".$row["Categoria"]."</td>";
								echo "<td>".$row["Modello"]."</td>";
								echo "<td>".$row["Descrizione"]."</td>";
								echo "<td>".$row["Quantita"]."</td>";
								echo "<td>".$row["PrezzoUnitario"]."</td>";
								echo "</tr>";
							}
						}
					}
					
				?>			
			</table>
	
			<h3>Contenuto del file</h3>
			<p>
				<?php
					if (isset($_SESSION["contenuto"]) == true)
						echo serialize($_SESSION["contenuto"]);
				?>
			</p>
			
		</div>
	</body>	
	
</html>