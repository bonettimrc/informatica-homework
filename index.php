<?php
$miaVar = 5;
if(1==1){
    echo "if: ";
    echo $miaVar;
    echo "<br>";
}
miaFunc();
function miaFunc()
{
    global $miaVar;
    echo "Funzione: ";
    echo $miaVar;
    echo "<br>";
}
?>