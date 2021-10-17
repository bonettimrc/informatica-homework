<?php
	// Aggiungere qui il codice PHP
	// per modificare il colore dei moduli alterando i valori delle variabili $colore[Name/Password]
	// per modificare il grassetto delle etichette alterando i valori delle variabili $bold[Name/Password]
	// 
	// Pensare anche alla conservazione dei valori dei moduli	
	if(isset($_POST["txtName"]) && strlen(trim($_POST["txtName"]))<6){
		$coloreName = "red";
		$boldName = "bold";
	}else{
		$coloreName = "revert";
		$boldName = "revert";
	}
	if(isset($_POST["txtPassword"]) && strlen(trim($_POST["txtPassword"]))<8){
		$colorePassword = "red";
		$boldPassword = "bold";
	}else{
		$colorePassword = "revert";
		$boldPassword = "revert";
	}
?>

<html>
	<head>
		<title>06.LOGIN</title>
		
		<style>
			label[for="txtName"]
			{
				color: <?php echo $coloreName; ?>;
				font-weight: <?php echo $boldName; ?>			
			}
			
			label[for="txtPassword"]
			{
				color: <?php echo $colorePassword; ?>;
				font-weight: <?php echo $boldPassword; ?>				
			}
			
			input[name="txtName"]
			{
				border-color: <?php echo $coloreName; ?>;
			}
			
			input[name="txtPassword"]
			{
				border-color: <?php echo $colorePassword; ?>;
			}
		</style>			
		
	</head>
	
	<body>
		
		<form name="frmLogin"
			action=""
			method="POST">
			
			<label for="txtName">Nome</label>
			<br>
			<input type="text" name="txtName" value="<?php echo isset($_POST["txtName"])?$_POST["txtName"]:"";?>">
			<br>
			
			<label for="txtPassword">Password</label>
			<br>
			<input type="text" name="txtPassword" value="<?php echo isset($_POST["txtPassword"])?$_POST["txtPassword"]:"";?>">
			<br>
			
			<input type="submit" name="invia" value="INVIA"> 
		
		</form>
	</body>
	
</html>