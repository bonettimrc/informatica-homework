<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
   <link rel="stylesheet" href="http://maxbeier.github.io/tawian-frontend/tawian-frontend.css">
   <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cousine:400,400i,700,700i">
</head>

<body>
   <div class="container">
      <h1>Titolo</h1>
      <form class="form" method="post" action="">
         <!-- Caselle di testo riga singola (textbox) -->
         <label class="form-group">
            <input type="text" name="textbox" class="form-control">
            <span class="form-label">Name</span>
         </label>

         <!-- Caselle di scelta multipla (checkbox) -->
         <label class="form-group">
            <div class="form-control">
               <label><input type="checkbox" name="checkboxA"> A</label>
               <label><input type="checkbox" name="checkboxB"> B</label>
            </div>
            <span class="form-label">Game</span>
         </label>
         <!-- Caselle di scelta esclusiva (radiobutton) -->
         <label class="form-group">
            <div class="form-control">
               <label><input type="radio" name="radiobutton" value="Maschio"> Maschio</label>
               <label><input type="radio" name="radiobutton" value="Femmina"> Femmina</label>
               <label><input type="radio" name="radiobutton" value="Altro"> Altro</label>
            </div>
            <span class="form-label">Genere</span>
         </label>
         <!-- Elenchi di selezione a comparsa (combobox) -->
         <label class="form-group">
            <select class="form-control" name="combobox">
               <option>Calabria</option>
               <option>Savoia</option>
            </select>
            <span class="form-label">Regione</span>
         </label>
         <label class="form-group">
            <!-- Elenchi di selezione a lista con selezione multipla(listbox) -->
            <input list="browsers" name="listbox">
            <datalist id="browsers">
               <option value="Internet Explorer">
               <option value="Firefox">
               <option value="Google Chrome">
               <option value="Opera">
               <option value="Safari">
            </datalist>
            <span class="form-label">Browser</span>
         </label>
         <!-- Caselle di testo multiriga (textarea) -->
         <label class="form-group">
            <textarea rows="5" name="textarea" class="form-control"></textarea>
            <span class="form-label">Descrizione</span>
         </label>
         <!-- File (upload)  -->
         <label class="form-group">
            <input type="file" name="upload" class="form-control">
            <span class="form-label">File</span>
         </label>
         <button type="submit" class="btn btn-primary full-width">Submit</button>
      </form>
      <?php
      if(count($_POST)!=0){
         echo '<samp class="full-width">'; 
         foreach ($_POST as $key=>$value) {
            echo "<p>".$key.":".$value."</p>";
         }
         echo '</samp>';
      }
    ?>
   </div>
</body>

</html>