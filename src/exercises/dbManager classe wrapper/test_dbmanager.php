<?php 
    include './DbManager.php';
    \test\DbManager::init();
    $conn = \test\DbManager::connect();
    $result = \test\DbManager::selectS($conn, "SOCCIA");
    print_r($result);
    
?>