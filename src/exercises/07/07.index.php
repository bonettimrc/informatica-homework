<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post">
        <label for="columns">columns:</label>
        <input type="number" name="columns" id="">
        <br>
        <label for="rows">rows:</label>
        <input type="number" name="rows" id="">
        <br>
        <input type="submit" value="submit">
    </form>
    <script>
        const rows=<?php echo isset($_POST["rows"])?$_POST["rows"]:"null"?>;
        const columns=<?php echo isset($_POST["rows"])?$_POST["rows"]:"null"?>;
        if(rows && columns){
            const table = document.createElement("table");
            for (let index = 0; index < rows; index++) {
                const tr = document.createElement("tr");
                for (let jndex = 0; jndex < columns; jndex++) {
                    const td = document.createElement("td");
                    td.innerHTML = `${index}:${jndex}`;
                    tr.append(td);
                }
                table.append(tr);
            }
            document.body.append(table);
        }
    </script>
</body>
</html>