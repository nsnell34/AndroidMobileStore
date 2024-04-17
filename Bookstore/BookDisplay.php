<?php
class BookDisplay{
    
    private $conn;
    private $host = "undcsmysql.mysql.database.azure.com";
    private $username = "nicholas.s.snell@undcsmysql";
    private $password = "nick5382";
    private $database = "nicholas_s_snell";

    public function __construct(){
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);
        if($this->conn->connect_error){
            die('Could not connect: ' . $this->conn->connect_error);
        }
    }

    public function Display() {
        $title = $_GET['title'];

        $sqlBook = "SELECT * FROM `book` WHERE `title` = '$title'";
        

        $result = $this->conn->query($sqlBook);
        if ($result->num_rows > 0) {
            $books = array();
            while ($bookData = $result->fetch_assoc() ){
                $ISBN = $bookData['ISBN'];
                $title = $bookData['title'];
                $price = $bookData['price'];

                $book = array(
                    "ISBN" => $ISBN,
                    "title" => $title,
                    "price" => $price
                );
                $books[] = $book;

            }

            $response = array(
                "books" => $books,
            );
            echo json_encode($response);
        } else {
            echo json_encode(array()); 
        }
    }
}


$bookInfo = new BookDisplay();
$bookInfo->Display();
?>