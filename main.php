<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Book Information Site</title>
    </head>
    <body>
        <br><h1><b>Book Information Site</b></h1>
        <br><hr>
        <h2><b>Search Books</b></h2>
        <form action=" search_books.php" method="get">
            <table style="text-align:center;">
                <tr>
                    <td>
                        <b>Search Books</b>
                    </td>
                    <td>
                        <select name=searchBy size=1>
                            <option>title1</option>
                            <option>author</option>
                            <option>isbn</option>
                        </select>
                    </td>
                </tr>
                <tr>
                     <td>
                        <b>Search Keyword</b>
                     </td>
                     
                     <td>
                        <input type=text name=searchKeyword>
                      </td>
                </tr>
                <tr>
                     <td> </td>
                     <td>
                        <input type=submit value=submit>
                      </td>
                </tr>
           </table>
        </form>
        <style>
            div.buttonHolder{
                 margin: auto;
                 display: block;
                 text-align: left;
            }
        </style>
        <form action=display_books.php method=get>
            <br><hr>
            <h2><b>Complete List of books</b></h2>
            <div
             class="buttonHolder">
                <input type=submit value="Complete list of books">
            </div>
           
        </form>
    </body>
</html>
