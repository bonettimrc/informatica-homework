<?php
	session_start(['use_strict_mode' => true]);

	// Se l'utente si disconnette...
	if (isset($_POST["btnLogOut"]) == true) {
		// Viene interrotta la sessione corrente
		session_destroy();
	
		// Viene inizializzata una nuova sessione
		session_start(['use_strict_mode' => true]);
	}
	
	if (isset($_POST["btnLogIn"]) == true) {
		$_SESSION["username"] = $_POST["txtUsername"];
	}
	
	if($_SESSION["username"]){
	// File utilizzato per la memorizzazione degli elementi
	$storage = $_SESSION["username"].".txt";
	
	// Array contenente tutti gli elementi
	$contenuto = array();

	// Valore commerciale dei prodotti visualizzati
	$valoreCommerciale = 0;
	
	// Elenco categorie univoche
	$categorie = array();
	
	// Categoria selezionata
	$filtro = "Qualsiasi";

	// Se è stato richiesto il reset...	
	if (isset($_POST["reset"]))
	{
		// Se la cartella uploads è presente...
		if (file_exists($_SESSION["username"]))
		{
			// Ottiene l'elenco dei file presenti in cartella
			$files = scandir($_SESSION["username"]);
			
			// Elimina tutti i file
			foreach($files as $file)
			{
				if (is_file($_SESSION["username"]."/".$file))
					unlink($_SESSION["username"]."/".$file);
			}
		}
		
		// Elimina il file utilizzato per lo storage
		if (file_exists($storage))
			unlink($storage);
	}

	// Caricamento dei contenuti precedenti
	// Deserializza il contenuto del file ottenendo un'istanza array
	if (file_exists($storage) == true)
		$contenuto = unserialize(file_get_contents($storage));	
	
	// Se è statao inviato qualcosa...
	if (isset($_POST["invia"]))
	{
		// Se la cartella non esiste...
		if (file_exists($_SESSION["username"]) == false)
			mkdir($_SESSION["username"]);	// crea la cartella
		
		// Definisce il percorso relativo del file
		$percorso = $_SESSION["username"]."/".$_FILES["miniatura"]["name"];
		
		// Sposta il file caricato
		move_uploaded_file(
			$_FILES["miniatura"]["tmp_name"],		  //temp
			$_SESSION["username"]."/".$_FILES["miniatura"]["name"]); //nome.ext
			
		// Determinazione indice elemento
		$newIndex = count($contenuto);
		
		for($p=0; $p<count($contenuto); $p++)
		{
			if ($contenuto[$p]["Modello"] == $_POST["modello"])
			{
				$newIndex = $p;
				break;
			}
		}
		
		// Array associativo (indici testuali)
		$contenuto[$newIndex] = array(
			"Percorso" => $percorso, 
			"Categoria" => $_POST["categoria"],
			"Modello" => $_POST["modello"],
			"Descrizione" => $_POST["descrizione"],
			"Quantita" => $_POST["quantita"],
			"PrezzoUnitario" => $_POST["prezzoUnitario"]
		);		
		
		// Aggiorniamo il contenuto del file utilizzato per lo storage
		file_put_contents($storage, serialize($contenuto));
	}
	
	// Verifica se l'utente ha selezionato una categoria
	if (isset($_POST["filtro"]))
		$filtro = $_POST["filtro"];
	
	// Operazione varie...
	foreach($contenuto as $item)
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
	</head>
	
	<body>
		<form action="" method="post">
			<input type="text" name="txtUsername">
			<input type="submit" value="LogIn" name="btnLogIn">
			<input type="submit" value="LogOut" name="btnLogOut">
		</form>
	<?php
		if(isset($_SESSION["username"])):
		?>
		<h3>Gestione Magazzino</h3>
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
				if (count($contenuto) > 0)
				{
					foreach($contenuto as $row)
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
				echo serialize($contenuto);
			?>
		</p>
		<?php
		endif;
	?>
	</body>	
	
</html>