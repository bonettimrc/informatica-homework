<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    img{
        width:150px;
    }
</style>
<body>
    <h1>Gestione Prodotti</h1>
<form method="POST" enctype="multipart/form-data">
			<label for="immagine">Immagine</label>
            <input type="file" name="immagine" id="immagine">
            <label for="categoria">Categoria</label>
            <input type="text" name="categoria" id="categoria">
            <label for="modello">Modello</label>
            <input type="text" name="modello" id="modello">
            <label for="prezzoUnitario">Prezzo unitario</label>
            <input type="number" name="prezzoUnitario" id="prezzoUnitario">
            <label for="quantità">Quantità</label>
            <input type="number" name="quantità" id="quantità">
			<label for="descrizione">Descrizione</label>
			<textarea name="descrizione" id="descrizione" rows="4"></textarea>
			<input type="submit" name="inserisci" value="Inserisci">
		</form>
        <hr>
        <form action="" method="get">
            <label for="filtro">Applica filtro per categoria:</label>
            <select name="filtro" id="filtro">
                <option value="qualsiasi">Qualsiasi</option>
                <option value="monitor">Monitor</option>
                <option value="tastiera">Tastiera</option>
            </select>
            <input type="submit" value="filtra" name="filtra">
        </form>
        
        <?php
	// File utilizzato per la memorizzazione degli elementi
	$storage = "data.json";
	
	// Array contenente tutti gli elementi
	$contenuto = array();

	// Caricamento dei contenuti precedenti
	// Deserializza il contenuto del file ottenendo un'istanza array
	if (file_exists($storage) == true)
		$contenuto = json_decode(file_get_contents($storage), true);
        $contenutoFiltrato = $contenuto;
        if(isset($_GET["filtra"]) && $_GET["filtro"]!="qualsiasi"){
            function filtro($value){
                return $value["categoria"]==$_GET["filtro"];
            }
            $contenutoFiltrato = array_filter($contenuto, "filtro");
        }
        $valoreCommerciale = 0;
        foreach ($contenutoFiltrato as $key => $value) {
            $valoreCommerciale+=(int)$value["prezzoUnitario"]* (int)$value["quantità"];
        }
        ?>
        <div>Valore commerciale:<?php echo $valoreCommerciale?></div>
        <table>
            <?php 
            // Scorre tutto il contenuto dell'array
                    foreach ($contenutoFiltrato as $key => $value) :
                        // Scrive la singola riga della tabella
                        ?>
                        <tr>
                            <td>
                                <img src="<?php echo $value["immagine"]?>" alt="">
                            </td>
                            <td>
                                <table>
                                    <tr>
                                        <td><?php echo $value["categoria"]?></td>
                                        <td><?php echo $value["modello"]?></td>
                                        <td><?php echo (int)$value["prezzoUnitario"]*(int)$value["quantità"]?></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo $key["descrizione"]?></td>
                                        <hr>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <table>
                            
                        </table>
                        <?php
                    endforeach;
            ?>
        </table>
        <?php
	
	// Se è statao inviato qualcosa...
	if (isset($_POST["inserisci"]))
	{
		// Se la cartella non esiste...
		if (file_exists("uploads") == false)
			mkdir("uploads");	// crea la cartella
		
		// Definisce il percorso relativo del file
		$percorso = "uploads/".$_FILES["immagine"]["name"];
		
		// Sposta il file caricato
		move_uploaded_file(
			$_FILES["immagine"]["tmp_name"],			//temp
			"uploads/".$_FILES["immagine"]["name"]); 	//nome.ext
			
		// Aggiorniamo il contenuto con il nuovo upload
		$newIndex = count($contenuto);
		$contenuto[$newIndex] = array(
			"immagine"=>$percorso, 
			"categoria"=>strtolower($_POST["categoria"]),
			"modello"=>$_POST["modello"],
            "prezzoUnitario"=>$_POST["prezzoUnitario"],
			"quantità"=>$_POST["quantità"],
            "descrizione"=>$_POST["descrizione"]
		);
		
		// Aggiorniamo il contenuto del file utilizzato per lo storage
		file_put_contents($storage, json_encode($contenuto));
	}
	
?>
</body>
</html>
