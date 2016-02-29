<?php
$file="test.xml";
echo "file = $file\n";
$currentTag = "authors";
if (strcmp($currentTag, "authors") == 0){
    echo "perfect match";
}else{
    echo "not perfect match";
}

/*
    if(!($fp = fopen($file, "r"))){
        die("Could not open $file for reading");
    }
    while(($data = fread($fp, 4096))){
        echo "$data";
    }
*/
        /*
        if(!xml_parse($xml_parser, $data, feof($fp))){
            echo "\n error in parsing\n";
            */
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title></title>
    </head>
    <body>
        
    </body>
</html>
