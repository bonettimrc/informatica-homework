<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="textbox" >Titolo immagine</label>
        <br>
        <input type="text" name="titolo">
        <br>
        <label for="textarea" >Descrizione immagine</label>
        <br>
        <textarea rows="5" name="descrizione"></textarea>
        <br>
        <input type="file" name="file">
        <br>
        <input type="submit" name="submit" value="Invia">
        <br>
    </form>
    <form action="" method="post">
        <input type="submit" name="azzera" value="Azzera">
    </form>
    <?php
        if (file_exists("list.txt") == true){
            $list = unserialize(file_get_contents("list.txt"));	
        }else{
            $list = array();
        }
        if (isset($_POST['submit'])) {
            $uploadPath = "uploads/" . basename($_FILES['file']['name']);
            if (!file_exists('./uploads')) {
                mkdir('./uploads', 0777, true);
            }
            move_uploaded_file($_FILES['file']['tmp_name'], "./".$uploadPath);
            $list[count($list)] = array(
                $uploadPath,
                $_POST["titolo"],
                $_POST["descrizione"],
    
            );
            file_put_contents("./list.txt", serialize($list));
        }
        if(isset($_POST['azzera'])){
            $files = glob('./uploads/*');
            foreach($files as $file){
                unlink($file);
            }
            if(file_exists('./list.txt')){
                unlink('./list.txt');
            }
        }
    ?>
    <table>
        <tr>
            <th>Miniatura</th><th>Titolo</th><th>Descrizione</th>
        </tr>
        <?php
            if(file_exists('./list.txt')){
                foreach ($list as $key => $value) {
                    echo "<tr><td><img src='".$value[0]."' width='100px'></td><td>".$value[1]."</td><td>".$value[2]."</td></tr>";
                }
            }
        ?>
    </table>
</body>

</html>