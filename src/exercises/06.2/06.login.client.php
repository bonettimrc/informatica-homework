<html>
<head>
    <title>06.LOGIN</title>
</head>
<body>
    <form name="frmLogin" action="" method="POST" onsubmit="return checkSubmit()">
        <label for="txtName" id="labelTxtTesto">Nome</label>
        <br>
        <input type="text" name="txtName">
        <br>
        <label for="txtPassword" id="labelTxtPassword">Password</label>
        <br>
        <input type="text" name="txtPassword">
        <br>
        <input type="submit" name="invia" value="INVIA">
    </form>
    <script>
        const itemName = document.getElementsByName("txtName")[0];
        const labelName = document.getElementById("labelTxtTesto");
        const itemPassword = document.getElementsByName("txtPassword")[0];
        const labelPassword = document.getElementById("labelTxtPassword");
        function checkSubmit() {
            let checkPassed = true;

            if (itemName.value.trim().length < 6) {
                labelName.style.color = "red";
                labelName.style.fontWeight = "bold";
                itemName.style.borderColor = "red"
                checkPassed = false;
            }else{
                labelName.style.color = "black";
                labelName.style.fontWeight = "normal";
                itemName.style.borderColor = "revert"
            }
            if (itemPassword.value.trim().length < 8) {
                labelPassword.style.color = "red";
                labelPassword.style.fontWeight = "bold";
                itemPassword.style.borderColor = "red"
                checkPassed = false
            }else{
                labelPassword.style.color = "black";
                labelPassword.style.fontWeight = "normal";
                itemPassword.style.borderColor = "revert"
            }
            return checkPassed
        }
    </script>
</body>
</html>