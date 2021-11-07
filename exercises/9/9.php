<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
        <button onclick="window.location.reload()">ricarica</button>
    </form>
    <?php
        if (isset($_POST['submit'])) {
            //definisco il percorso locale
            $uploadPath = "uploads/" . basename($_FILES['file']['name']);
            //sposto il file dal percorso temporaneo ad il percorso di destinazione, ottenuto unendo il percorso dell'applicazione a quello relativo
            move_uploaded_file($_FILES['file']['tmp_name'], realpath(dirname(__FILE__))."/".$uploadPath);
            ?>
                <h1>
                    <?php echo $_POST["titolo"]?>
                </h1>
                <p>
                    <?php echo $_POST["descrizione"]?>
                </p>
                <p>
                    <?php
                        echo "nome inviato dal client:".$_FILES['file']['name']."<br>";
                        echo "tipo mime:".$_FILES["file"]["type"]."<br>";
                        echo "percorso temporaneo:".$_FILES['file']['tmp_name']."<br>";
                        echo "percorso assegnato sul server:".$uploadPath."<br>";
                        echo "errore:".$_FILES["file"]["error"]."<br>";
                        echo "dimensione in bytes:".$_FILES["file"]["size"]."<br>";
                    ?>
                </p>
                <img src="<?php echo $uploadPath?>" alt="">
                <br>
                <button onclick="defaultSize()">mostra l'immagine a dimensioni reali</button>
                <br>
                <button onclick="incrementHorizontalSize(10)">incrementa le dimensioni orizzontali del 10%</button>
                <br>
                <button onclick="incrementHorizontalSize(-10)">decrementa le dimensioni orizzontali del 10%</button>
                <br>
                <button onclick="setHorizontalSizeToWindowInnerWidth()">dimensione orizzontale impostata di default al 100% della pagina</button>
                <br>
            <?php
        }
    ?>
    <script>
        const img = document.querySelector("img");
        function defaultSize() {
            img.width = img.naturalWidth
        }
        function incrementHorizontalSize(percentage) {
            img.width += ((percentage) / 100) * img.naturalWidth
        }
        function setHorizontalSizeToWindowInnerWidth() {
            img.width = window.innerWidth
        }
    </script>
</body>

</html>