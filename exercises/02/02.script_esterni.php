<html>
	<body>
		<h1>Script esterni, include/include_once e require/require_once</h1>

		<h2>require("file") o require "file"</h2>
		<p>Include il contenuto di uno script esterno nel punto in cui viene iniettato</p>
		<p>Se il file non è accessibile lo script VIENE INTERROTTO</p>
		<p>Lo stesso file può essere incluso più volte se non contiene definizione di funzioni o classi</p>
		
		<h2>include_once("file") o include_once "file"</h2>
		<p>Include il contenuto di uno script esterno nel punto in cui viene iniettato</p>
		<p>Se il file non è accessibile lo script VIENE INTERROTTO</p>
		<p>SOLO SE NON E' GIA' STATAO INCLUSO IN PRECEDENZA</p>
			
		<h2>inlcude("file") o include "file"</h2>
		<p>Include il contenuto di uno script esterno nel punto in cui viene iniettato</p>
		<p>Se il file non è accessibile lo script prosegue comunque</p>
		<p>Lo stesso file può essere incluso più volte se non contiene definizione di funzioni o classi</p>
		
		<h2>include_once("file") o include_once "file"</h2>
		<p>Include il contenuto di uno script esterno nel punto in cui viene iniettato</p>
		<p>Se il file non è accessibile lo script prosegue comunque</p>
		<p>SOLO SE NON E' GIA' STATAO INCLUSO IN PRECEDENZA</p>

<?php
	
	// Include uno script esterno anche più volte
	require("02.esterno.php");
	require("02.esternoF.php");
	echo "<hr>";
	echo "<p>Tutto OK: frutto:$frutto | variet&agrave;:$varieta<p>";
	stampa();
?>

	</body>

</html>