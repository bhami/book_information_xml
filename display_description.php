<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Table of Contents</title>
    </head>
    <body>
<?php
    $isbn = $_GET['isbn'];
    require("common.php");
    $currentTag1 = "";
    $chapters = array();
    $chapterNo=0;
    $appendixes = array();
    $appendixNo=0;
   

// definition of startelement handler of the parser

function startElement1($parser, $name, $attr){
    global $currentTag1;
    $currentTag1 = $name;
}

//definition of endelement handler of the parser
function endElement1($parser, $name){
    global $chapterNo, $appendixNo;
    if (strcmp($name, "chapter") == 0){
        $chapterNo++;
    } elseif (strcmp($name, "appendix") == 0){
        //echo "incrementing appendix";
        $appendixNo++;
    }
}


//defintion of character data handler

function characterData1($parser, $data){
    global $chapters, $chapterNo, $appendixes, $appendixNo, $currentTag1;
    if (strcmp($currentTag1, "chapter")==0){
        $chapters[$chapterNo] .= $data;
    }elseif (strcmp($currentTag1, "appendix")==0){
        //echo "data= $data";
        $appendixes[$appendixNo] = $data;
        //echo "appendix=".$appendixes[$appendixNo];
    }
 }
 

// parse book.xml and find the book with an <isbn> element which has the 
// same value as $isbn
$books = readBookInfo();
if(!($books =searchBookByISBN($books, $isbn))) {
    echo "Book with ISBN $isbn does not exist";
}

$titleValue = $books["title1"];
$authors = $books["authors"];

for($j=0, $authorsValue=""; $j< count($authors)-1; $j++) {
    if($j != 0)
        $authorsValue .= ", ";
    $authorsValue .= $authors[$j];
}

//print the title and authors of the book as a heading

print "<B><FONT SIZE=6>$titleValue</FONT></B>";
print "<BR>";
print "by ";
for ($j=0; $j< count($authors)-1; $j++){
    if ($j != 0)
        print ", ";
    print "$authors[$j]";
}

//create a parser for XML document containing the TOC of the book
    $xml_parser = xml_parser_create();
    if(!xml_set_element_handler($xml_parser, "startElement1", "endElement1")){
        echo "failed in xml set element handler\n";
    };
    if(!xml_set_character_data_handler($xml_parser, "characterData1")){
        echo "failed in xml set character data handler";
    };
    if(!xml_parser_set_option($xml_parser,XML_OPTION_CASE_FOLDING, false)){
        echo "failed in CASe FOLDING OPTION";
    };
    
// Open the xml file with TOC for parsing, read the data in 4k chunk 
// and pass it to the xml parser
  if(!($fp = fopen($books["description"], "r"))){
        echo "Could not open ".$books["description"]. " for reading";
    }

    while(($data = fread($fp, 4096))){
        if(!xml_parse($xml_parser, $data, feof($fp))){
            echo "\n error in parsing= xml_get_current_line_number($xml_parser)";
            die(sprintf("XML error at line %d column %d",
                        xml_get_current_line_number($xml_parser),
                        xml_get_current_column_number($xml_parser)));
                      
        }
    }   
    xml_parser_free($xml_parser);
  
?>

<hr><br>
<b>Table of Contents</b>
<br><br>

<?php
    for($i=0; $i< count($chapters)-1; $i++){
        print "Chapter ".($i+1). ": $chapters[$i] <br>";
    }
    print "<br>";
   // echo "appendix = $apendixes[1]"." and count =" . count($appendixes) ;
    //print_r($appendixes);
    for($i=0; $i< count($appendixes)-1; $i++){
        //echo "going inside appendeix";
        // add the integer in the ascii value of char "A" and then 
        //write it back the char(Alaphabet) of equivalent value
        $j= chr(ord("A") + $i);
        //echo "j=$j";
        printf("Appendix %s: %s <br>\n", $j, $appendixes[$i]);
 
   }

  
?>


</body>
</html>

    