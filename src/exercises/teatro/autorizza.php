<?php session_start(['use_strict_mode' => true]);
    if (isset($_POST["rsubmit"]))
	{
		// Imposta il percorso del file da utilizzare
		$storage = "storage.txt";
		// Caricamento dei contenuti precedenti
		// Deserializza gli utenti del file ottenendo un'istanza array
		if (file_exists($storage) == true)
			$utenti = unserialize(file_get_contents($storage));
		else
			$utenti = array();
        // Controlla se l'utente esiste già, senno lo aggiunge
        $alreadyExist=false;
        foreach ($utenti as $utente) {
            if($utente["username"]===$_POST["rusername"])
                $alreadyExist=true;
        }
        if(!$alreadyExist){
            $utenti[count($utenti)] = array(
                "username"=>$_POST["rusername"], 
                "nome"=>$_POST["rnome"], 
                "password"=>$_POST["rpassword"]
            );
            // aggiorna contenuto file
            file_put_contents($storage, serialize($utenti));
             // carica info utente nella sessione
             $_SESSION["utente"]=$utenti[count($utenti)-1];
             // reindirizza a prenote.php
             header('Location: prenota.php');
        }  
        else{
            echo "username duplicato";// TODO: username duplicato
        }
	}
    
	if (isset($_POST["lsubmit"]))
	{
        
		// Imposta il percorso del file da utilizzare
		$storage = "storage.txt";
		// Caricamento dei contenuti precedenti
		// Deserializza gli utenti del file ottenendo un'istanza array
		if (file_exists($storage) == true)
			$utenti = unserialize(file_get_contents($storage));
		else
			$utenti = array();
        // Trova l'indice dell'utente
        $indice;
        for ($i=0; $i < count($utenti); $i++) { 
            if($utenti[$i]["username"]===$_POST["lusername"]&&$utenti[$i]["password"]===$_POST["lpassword"])
                $indice=$i;
        }
        
        if(isset($indice)){
            
            // carica info utente nella sessione
            $_SESSION["utente"]=$utenti[$indice];
            // reindirizza a prenote.php
            header('Location: prenota.php');
        }
        else{
            // TODO: l'utente non esiste
        }
	}
    
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Teatro Autorizza</h1>
    <h2>Utente registrato? Effettua il login</h2>
    <form action="" method="post">
        <label for="lusername">Login</label>
        <input type="text" name="lusername" id="lusername">
        <label for="lpassword">Password</label>
        <input type="text" name="lpassword" id="lpassword">
        <input type="submit" name="lsubmit" value="Accedi">
    </form>
    <h2>Utente non registrato? Effettua la registrazione</h2>
    <form action="" method="post">
        <label for="rnome">Nome</label>
        <input type="text" name="rnome" id="rnome">
        <label for="rusername">Login</label>
        <input type="text" name="rusername" id="rusername">
        <label for="rpassword">Password</label>
        <input type="text" name="rpassword" id="rpassword">
        <input type="submit" name="rsubmit" value="Registra">
    </form>
    
</body>
</html>