<?php
	// File utilizzato per la memorizzazione degli elementi
	$storage = "11.list.serialize.txt";
	
	// Array contenente tutti gli elementi
	$contenuto = array();

	// Se è stato richiesto il reset...	
	if (isset($_POST["reset"]))
	{
		// Se la cartella uploads è presente...
		if (file_exists("uploads"))
		{
			// Ottiene l'elenco dei file presenti in cartella
			$files = scandir("uploads");
			
			// Elimina tutti i file
			foreach($files as $file)
			{
				if (is_file("uploads/".$file))
					unlink("uploads/".$file);
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
		if (file_exists("uploads") == false)
			mkdir("uploads");	// crea la cartella
		
		// Definisce il percorso relativo del file
		$percorso = "uploads/".$_FILES["upload"]["name"];
		
		// Sposta il file caricato
		move_uploaded_file(
			$_FILES["upload"]["tmp_name"],			//temp
			"uploads/".$_FILES["upload"]["name"]); 	//nome.ext
			
		// Aggiorniamo il contenuto con il nuovo upload
		$newIndex = count($contenuto);
		$contenuto[$newIndex] = array(
			"percorso"=>$percorso, 
			"titolo"=>$_POST["titolo"],
			"descrizione"=>$_POST["descrizione"]
		);
		
		// Aggiorniamo il contenuto del file utilizzato per lo storage
		file_put_contents($storage, serialize($contenuto));
	}
	
?>

<html>
	<head>
		<title>11.list.serialize</title>
	</head>
	
	<body>
		<h3>Memorizzazione del contenuto di un array multidimensionale serializzato</h3>

		<form method="POST" enctype="multipart/form-data">
			<label>Titolo</label><br>
			<input type="text" name="titolo"><br>
			<label>Descrizione</label><br>
			<input type="text" name="descrizione"><br>
			<label>Immagine</label><br>
			<input type="file" name="upload"><br><br>
			<input type="submit" name="invia" value="invia">
			<input type="submit" name="reset" value="reset">
		</form>
		
		<table>
			<?php
				
				// Scorre tutto il contenuto dell'array
				foreach($contenuto as $row)
				{
					// Scrive la singola riga della tabella
					echo "<tr>";
					echo "<td><img style=\"width:150px;\" src=\"".$row["percorso"]."\"></td>";
					echo "<td>".$row["titolo"]."</td>";
					echo "<td>".$row["descrizione"]."</td>";
					echo "</tr>";
				}
			?>			
		</table>

		<h3>Contenuto del file</h3>
		<p>
			<?php
				echo serialize($contenuto);
			?>
		</p>
	</body>	
	
</html>