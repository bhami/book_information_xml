<?php

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Search Results</title>
    </head>
    <body>
        <b>Search Results</b>
        <hr><br>
        <table border=1>
            <thead>
                <tr>
                    <th>title</th>
                    <th>authors</th>
                    <th>isbn</th>
                    <th>price</th>
                </tr>
             </thead>
            <tbody>
                <?php
                    $searchKeyword = $_GET["searchKeyword"];
                     $searchBy = $_GET["searchBy"];
                     require("common.php");
                     $books = readBookInfo();
                     if (strcmp($searchBy, "isbn") == 0) {
                        if(($book_ret = searchBookByISBN($books, $searchKeyword))){
                            //echo "after serachBYISBN";
                            //print_r($book_ret);
                            printBookInfo($book_ret["title1"], $book_ret["authors"],
                                         $book_ret["isbn"], $book_ret["price"],
                                         $book_ret["currency"]);
                        }
                    } elseif(strcmp($searchBy, "author")==0){
                        for($i=0; $i<count($books); $i++){
                            $authorsValue = $books[$i]["authors"];
                            for ($j=0; $j<count($authorsValue)-1; $j++){
                                if(strcmp(strtolower(trim($authorsValue[$j])),
                                          strtolower(trim($searchKeyword))) == 0){
                                              //echo "going in author match";
                                    printBookInfo($books[$i]["title1"],
                                                  $books[$i]["authors"],$books[$i]["isbn"],
                                                  $books[$i]["price"],$books[$i]["currency"]);
                                          }
                              }
                          }
                     } elseif(strcmp($searchBy, "title1")==0){
                        for($i=0; $i<count($books); $i++){
                            if(strstr(strtolower(trim($books[$i]["title1"])),
                                      strtolower(trim($searchKeyword))))
                                    printBookInfo($books[$i]["title1"],
                                    $books[$i]["authors"],$books[$i]["isbn"],
                                    $books[$i]["price"],$books[$i]["currency"]);
                              }
                      } 
                ?>
            </tbody>
          </thead>
        </table>
    </body>
</html>
