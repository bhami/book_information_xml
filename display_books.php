<?php
//echo "in display_book php file\n";
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Complete list of Books</title>
    </head>
    <body>
        <h1>Complete list of books</h1>
        <hr><br>
        <table border=1>
            <thead>
                <tr>
                    <th> title </th>
                    <th> authors </th>
                    <th> isbn </th>
                    <th> price </th>
                </tr>
            </thead>
            <tbody>
                <?php
                    require("common.php");
                    $books = readBookInfo();
                    for($i=0; $i<count($books); $i++){
                         printBookInfo($books[$i]["title1"], $books[$i]["authors"],
                                      $books[$i]["isbn"], $books[$i]["price"],
                                      $books[$i]["currency"]);
                    }
                    
                ?>
            </tbody>
        </table>
    </body>
</html>
