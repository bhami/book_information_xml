<?php
//common.php for all functions
//made a small change
$file = "books.xml";
$currentTag = "";
$titleValue = "";
$authorsValue = array();
$isbnValue = "";
$priceValue = "";
$currencyValue = "";
$descriptionValue = "";
$authorCount = 0;

$books = array();

// definition of startelement handler of the parser
function startElement($parser, $name, $attr){
    global $currentTag, $currencyValue;
    $currentTag = $name;
    if(strcmp($name, "price") == 0)
        $currencyValue = $attr["currency"];
}

//definition of endelement handler of the parser
function endElement($parser, $name){
    global $titleValue, $authorsValue, $isbnValue, $priceValue,$testC,
           $currencyValue, $books, $authorCount, $descriptionValue;
    if (strcmp($name, "book") == 0){
        $books[] = array("title1"=>$titleValue,
                         "authors"=>$authorsValue,
                         "isbn"=> $isbnValue,
                         "price"=> $priceValue,
                         "currency"=>$currencyValue,
                         "description"=>$descriptionValue
                         );
        $titleValue = "";
        $authorsValue = array();
        $isbnValue = "";
        $priceValue = "";
        $authorCount = 0;
        $currencyValue = "";
        $descriptionValue = "";
    } elseif (strcmp($name, "author") == 0){
        $authorCount++;
        $authorsValue[$authorCount] = "";
    }
}


//defintion of character data handler

function characterData($parser, $data){
    global $titleValue, $authorsValue, $isbnValue, $priceValue,
           $currencyValue, $books, $authorCount, $descriptionValue, $currentTag;
    
    if (strcmp($currentTag, "title1")==0){
        $titleValue .= $data;
    }elseif (strcmp($currentTag, "author") ==0){
        $authorsValue[$authorCount] = $data;
    }elseif (strcmp($currentTag, "isbn") ==0){
        $isbnValue .= $data;
    }elseif (strcmp($currentTag, "price") ==0){
        $priceValue .= $data;
    }
                          
}

//function to return an array with details of the book with a given ISBN
function searchBookByISBN($books, $isbn){
    for($i=0; $i< count($books); $i++){
        if (strcmp(trim($books[$i]["isbn"]), trim($isbn)) == 0){
            return $books[$i];
        }
    }
    return NULL;
}



function externalEntityHandler($parser, $entityName, $base,
                               $systemId, $publicId) {

    global $descriptionValue;
    if(!systemId)
        return false;
    $descriptionValue =  $systemId;
    return true;                                 
}


function readBookInfo(){
    global $file, $books;
    $xml_parser = xml_parser_create();
    if(!xml_set_element_handler($xml_parser, "startElement", "endElement")){
        echo "failed in xml set element handler\n";
    };
    if(!xml_set_character_data_handler($xml_parser, "characterData")){
        echo "failed in xml set character data handler";
    };
    if(!xml_set_external_entity_ref_handler($xml_parser, "externalEntityHandler")){
        echo "failed in xml set external entity ref  handler";
    };
    if(!xml_parser_set_option($xml_parser,XML_OPTION_CASE_FOLDING, false)){
        echo "failed in CASe FOLDING OPTION";
    };
    if(!($fp = fopen($file, "r"))){
        die("Could not open $file for reading");
    }
    while(($data = fread($fp, 4096))){
        if(!xml_parse($xml_parser, $data, feof($fp))){
            echo "\n error in parsing= xml_get_current_line_number($xml_parser)";
            /*
            die(sprintf("XML error at line %d column %d",
                        xml_get_current_line_number($xml_parser),
                        xml_get_current_column_number($xml_parser)));
                        */
        }
        
    }
   
    xml_parser_free($xml_parser);
      
    return $books;
}

// function to print  details of books in a row of HTML table

function printBookInfo($titleValue, $authorsValue, $isbnValue, $priceValue,
                       $currencyValue) {
    print "<tr>";
    print "<td><a href=\"display_description.php?isbn=$isbnValue\">$titleValue</a></td>";
    print"<td>";
    $cnt = (count($authorsValue)-1);
    for($j=0; $j<$cnt; $j++){
        if($j != 0){
            print ",";
        }
        print " $authorsValue[$j] ";
    }
    print "</td>";
    print "<td>$isbnValue</td>";
    print "<td>$priceValue $currencyValue</td>";
    print"</tr>";   
    return null;                        
}




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
