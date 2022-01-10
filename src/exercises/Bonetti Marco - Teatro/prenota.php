<?php session_start(['use_strict_mode' => true]);
    if($_SESSION["utente"]){
        $utente = $_SESSION["utente"];
    }
    // Imposta il percorso del file da utilizzare
	$storage = "posti.txt";
	// Caricamento dei contenuti precedenti
	// Deserializza i posti del file ottenendo un'istanza array
	if (file_exists($storage) == true)
		$posti = unserialize(file_get_contents($storage));
	else
		{
            $posti = array();
            for ($i=0; $i < 10; $i++) { 
                $posti[$i]=array();
                for ($j=0; $j < 15; $j++) {
                    $posti[$i][$j]="non prenotato";
                }
            }
        }
    foreach ($_POST as $key => $value) {
        if(substr( $key, 0,1 ) === "p" && isset($value)){
            // prenota posto
            $rigaEColonna = explode(';',substr($key, 1));
            $riga = intval($rigaEColonna[0]);
            $colonna = intval($rigaEColonna[1]);
            $posti[$riga][$colonna] = $utente["username"];
            // aggiorna contenuto file
            file_put_contents($storage, serialize($posti));
        }
    }
    if(isset($_POST["aggiorna"])){
        // TODO
    }
    if (isset($_POST["logout"])) {
        session_destroy();
        header('Location: autorizza.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .prenotato{
            background-color:red;
        }
        .prenotato_da_me{
            background-color:yellow;
        }
        .non_prenotato{
            background-color:green;
        }
    </style>
</head>
<body>
    <h1>Teatro Prenotazioni</h1>
    <h2><?php echo $utente?"benvenuto ".$utente['nome']:"";?></h2>
    <form action="" method="post">
        <input type="submit" name="aggiorna" value="Aggiorna">
        <input type="submit" name="logout" value="Logout">
    </form>
    <!-- messaggio -->
    <p></p>
    <!-- caselle -->
    <form action="" method="post">
        <table>
            <?php 
                $alphabet = range('A', 'J');
                for ($i=0; $i < 10; $i++) { 
                    echo "<tr>";
                    for ($j=0; $j < 15; $j++) {
                        $class="prenotato";
                        if($posti[$i][$j]===$utente["username"]){
                            $class="prenotato_da_me";
                        }
                        if($posti[$i][$j]==="non prenotato"){
                            $class="non_prenotato";
                        }
                        
                        echo "<th><input type='submit' class='$class' name='p$i;$j' value='$alphabet[$i]$j'></th>";
                    }
                    echo "</tr>";
                }
            ?>
        </table>
    </form>
</body>
</html>