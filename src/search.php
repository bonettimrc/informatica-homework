<?php
    function getDirContents($dir, &$results = array()) {
        $files = scandir($dir);
    
        foreach ($files as $key => $value) {
            $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
            if (!is_dir($path)) {
                $results[] = $path;
            } else if ($value != "." && $value != "..") {
                getDirContents($path, $results);
            }
        }
        return $results;
    }
    $resultPath = array();
    $dirContents = getDirContents("./");
    foreach ($dirContents as $key => $value) {
        if(strpos($value, $_GET["q"])!==false){
            $result = str_replace("C:\\home\\site\\wwwroot","",$value);
            $resultPath[count($resultPath)] = str_replace("/var/www/html","",$result);
            if(count($resultPath)>=$_GET["n"]){
                break;
            }
        }
    }
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($resultPath);
?>