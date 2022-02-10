<?php 
    include './DbManager.php';
    DbManager::init();
    $conn = DbManager::connect("northwind");
    $result = DbManager::selectS($conn, "SELECT * FROM `prodotti`");
    print_r($result);
?>