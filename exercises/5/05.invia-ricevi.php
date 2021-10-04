<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>05.invia-ricevi</title>
</head>
<body>
    <?php 
        if(!isset($_POST["txtNome"])):
    ?>
    <form method="POST" action="05.invia-ricevi.php">
		<label for="txtNome">Nome</label>
		<br>
		<input type="text" name="txtNome">
		<br>
		<input type="submit" value="Invia">
	</form>
    <?php else :?>
    <h1>Benvenuto
    <?php
        echo $_POST["txtNome"];
    endif;
	?>
	</h1>
</body>
</html>