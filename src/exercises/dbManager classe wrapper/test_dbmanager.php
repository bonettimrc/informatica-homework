<?php 
    include './DbManager.php';
    MyNamespace\DbManager::init();
    $conn = MyNamespace\DbManager::connect("northwind");
    $result = MyNamespace\DbManager::selectS($conn, "SELECT * FROM `prodotti`");
    print_r($result);
?>