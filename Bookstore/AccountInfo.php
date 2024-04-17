<?php
class AccountInfo{
    
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

    public function DisplayAccount() {
        $name = $_GET['name'];
        $password = $_GET['password'];

        $sqlUser = "SELECT * FROM `customer` WHERE `name` = '$name' AND `password` = '$password'";
        $userResult = $this->conn->query($sqlUser);
        if ($userResult->num_rows > 0) {
            $userData = $userResult->fetch_assoc();
            $userID = $userData['ID'];
            $totalSpent = $userData['total_spent'];

            $bookTitlesQuery = "SELECT `title` FROM `purchases` WHERE `custID` = '$userID'";
            $booksResult = $this->conn->query($bookTitlesQuery);

            $books = array();
            while ($bookRow = $booksResult->fetch_assoc()) {
                $book = array(
                    "title" => $bookRow['title']
                );
                $books[] = $book;
            }
            $books = array_map("unserialize", array_unique(array_map("serialize", $books)));

            $response = array(
                "books" => $books,
                "total_spent" => $totalSpent
            );
            echo json_encode($response);
        } else {
            echo json_encode(array()); 
        }
    }
}


$accountInfo = new AccountInfo();
$accountInfo->DisplayAccount();
?>