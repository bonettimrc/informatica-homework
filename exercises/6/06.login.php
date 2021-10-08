
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
</head>
<body>
    <?php
        $correctUsername=false;
        $correctPassword=false;
        if(isset($_POST["username"])){
            if(strlen($_POST["username"])>=6){
                $correctUsername = true;
            }
            else{
                ?>
                <style>
                    #usernameLabel{
                        color: red;
                        font-weight:bold;
                    }
                    #username{
                        border-color: red;
                    }
                </style>
                <?php
            }
        }
        if(isset($_POST["password"])){
            if(strlen($_POST["password"])>=8){
                $correctPassword = true;
            }
            else{
                ?>
                <style>
                    #passwordLabel{
                        color: red;
                        font-weight:bold;
                    }
                    #password{
                        border-color: red;
                    }
                </style>
                <?php
            }
        }
    ?>
    
    <form action="<?php echo $correctUsername&&$correctPassword?"06.benvenuto.php":"06.login.php";?>" method="post" id="form">
        <label for="username" id="usernameLabel">Username</label>
        <input type="text" name="username" id="username" value="<?php echo isset($_POST["username"])?$_POST["username"]:"";?>">
        <label for="password"  id="passwordLabel">Password</label>
        <input type="password" name="password" id="password" value="<?php echo isset($_POST["password"])?$_POST["password"]:"";?>">
        <input type="submit" value="submit">
    </form>
    <?php
        if($correctUsername && $correctPassword){
            ?>
            <script type="text/javascript">
                document.getElementById('form').submit();
            </script>
            <?php
        }
    ?>
</body>
</html>