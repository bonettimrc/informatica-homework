<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table, tr{
            border: 1px solid black;
        }
    </style>
</head>

<body>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="textbox">Titolo immagine</label>
        <br>
        <input type="text" name="titolo">
        <br>
        <label for="textarea">Descrizione immagine</label>
        <br>
        <textarea rows="5" name="descrizione"></textarea>
        <br>
        <input type="file" name="file">
        <br>
        <input type="submit" name="submit" value="Invia">
        <br>
    </form>
    <?php
        if (isset($_POST['submit'])) {
            //definisco il percorso locale
            $uploadPath = "uploads/" . basename($_FILES['file']['name']);
            //sposto il file dal percorso temporaneo ad il percorso di destinazione, ottenuto unendo il percorso dell'applicazione a quello relativo
            move_uploaded_file($_FILES['file']['tmp_name'], "./".$uploadPath);
            //carica la riga della tabella nel riepilogo, uso la flag FILE_APPEND per non sovrascrivere le precedenti righe
            file_put_contents("./riepilogo.html", "<tr><td><img src='".$uploadPath."' width='100px'></td><td>".$_POST["titolo"]."</td><td>".$_POST["descrizione"]."</td></tr>", FILE_APPEND);
        }
    ?>
    <table>
        <tr>
            <th>Miniatura</th><th>Titolo</th><th>Descrizione</th>
        </tr>
        <?php //se il file della righe esiste lo stampa all'interno di una table 
        echo file_exists("./riepilogo.html")?file_get_contents("./riepilogo.html"):""?>
    </table>
</body>

</html>