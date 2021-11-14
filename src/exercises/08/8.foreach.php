<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
</head>

<body>

   <form class="form" method="post" action="">
      <!-- Caselle di testo riga singola (textbox) -->
      <label for="textbox">Name</label>
      <input type="text" name="textbox">
      <br><br>
      <!-- Caselle di scelta multipla (checkbox) -->
      Scelte
      <label for="checkboxA">A</label>
      <input type="checkbox" name="checkboxA">
      <label for="checkboxB">B</label>
      <input type="checkbox" name="checkboxB">
      <br><br>
      <!-- Caselle di scelta esclusiva (radiobutton) -->
      Genere
      <input type="radio" name="radiobutton" value="Maschio"> Maschio
      <input type="radio" name="radiobutton" value="Femmina"> Femmina
      <input type="radio" name="radiobutton" value="Altro"> Altro
      <br><br>
      <!-- Elenchi di selezione a comparsa (combobox) -->
      <label for="combobox">Regione</label>
      <select name="combobox">
         <option>Calabria</option>
         <option>Savoia</option>
      </select>
      <br><br>
      <!-- Elenchi di selezione a lista con selezione multipla(listbox) -->
      <label for="listbox">Browser</label>
      <input list="browsers" name="listbox">
      <datalist id="browsers">
         <option value="Internet Explorer">
         <option value="Firefox">
         <option value="Google Chrome">
         <option value="Opera">
         <option value="Safari">
      </datalist>
      <br><br>
      <!-- Caselle di testo multiriga (textarea) -->
      <label for="textarea">Descrizione</label>
      <textarea rows="5" name="textarea"></textarea>
      <br><br>
      <!-- File (upload)  -->
      <label for="upload">File</label>
      <input type="file" name="upload">
      <button type="submit">Submit</button>
      <br><br>
   </form>
   <?php
        foreach ($_POST as $key=>$value) {
            echo "<p>".$key.":".$value."</p>";
        }
    ?>
   </div>
</body>

</html>