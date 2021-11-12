<?php

	// --------------------------------------
	// Valori predefinito per "Nome"
	$nameError = false;
	$nameValue = "";

	// Ottiene il valore (se inviato)
	if (isset($_POST["txtName"]) == true)
		$nameValue = $_POST["txtName"];
	// Imposta lo stato di errore se
	// - il dato non soddisfa la convalida
	// - il dato è stato inviato
	if (isset($_POST["txtName"]) == true && strlen($nameValue) < 6)
		$nameError = true;

	// --------------------------------------
	// Valori predefinito per "Password"
	$passwordError = false;
	$passwordValue = "";

	// Ottiene il valore (se inviato)
	if (isset($_POST["txtPassword"]) == true)
		$passwordValue = $_POST["txtPassword"];
	// Imposta lo stato di errore se
	// - il dato non soddisfa la convalida
	// - il dato è stato inviato
	if (isset($_POST["txtPassword"]) == true && strlen($passwordValue) < 8)
		$passwordError = true;
?>

<html>
	<head>
		<title>06.LOGIN</title>
		
		<style>
			.labelError
			{
				color: red;
				font-weight: bold;				
			}

			.moduleError			
			{
				border-color: red;
			}
		</style>			
		
		<script src="https://code.jquery.com/jquery-3.6.0.slim.js" integrity="sha256-HwWONEZrpuoh951cQD1ov2HUK5zA5DwJ1DNUXaM6FsY=" crossorigin="anonymous"></script>
	</head>
	
	<body>
		
		<form name="frmLogin"
			action=""
			method="POST">
			
			<label id="labelName" for="txtName">Nome</label>
			<br>
			<input type="text" name="txtName" value="">
			<br>
			
			<label id="labelPassword" for="txtPassword">Password</label>
			<br>
			<input type="text" name="txtPassword" value="">
			<br>
			
			<input type="submit" name="invia" value="INVIA"> 
		
		</form>
		
		<script>
			// Modificare i selettori con jQuery al fine 
			// di modificare lo stile in base all'errore
			$(document).ready(function()
				{
					var nameError = <?php echo ($nameError)? "true" : "false"; ?>;
					var nameValue = "<?php echo $nameValue; ?>";
					
					if (nameError)
					{
						$("[name='txtName']")[0].className = "moduleError";
						$("#labelName")[0].className = "labelError";
					}
					$("[name='txtName']")[0].value = nameValue;
					
					
					var passwordError = <?php echo ($passwordError)? "true" : "false"; ?>;
					var passwordValue = "<?php echo $passwordValue; ?>";
					if (passwordError)
					{
						document.getElementsByName("txtPassword")[0].className = "moduleError";
						document.getElementById("labelPassword").className = "labelError";
					}
					document.getElementsByName("txtPassword")[0].value = passwordValue;
				});
		</script>
		
	</body>
	
</html>