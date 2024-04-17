<?php 


error_reporting(-1);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL ^ E_WARNING ^ E_DEPRECATED);
ini_set("session.gc_maxlifetime", "180000");

ignore_user_abort(1);
set_time_limit(1800);


class PurchaseBook{
    
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

    public function purchase() {
        $name = $_GET['name'];
        $password = $_GET['password'];
        $books = urldecode($_GET['books']);

        //echo($name . " " . $password . " " . $books . "\n");

        $booksArray = explode(",", $books);
        $userSql = "SELECT `ID` FROM `customer` WHERE `name` = '$name' AND `password` = '$password'";
        $userResult = $this->conn->query($userSql);
        $userRow = $userResult->fetch_assoc();
        $userID = $userRow['ID']; 


        $totalAmount = 0;
        foreach ($booksArray as $book) {
            $sql = "SELECT `ISBN`, `price` FROM `book` WHERE `title` = '$book'";
            $result = $this->conn->query($sql);
            $row = $result->fetch_assoc();
            $ISBN = $row['ISBN'];
            $price = $row['price'];
            
            $enterPurchase = "INSERT INTO `purchases` (`custID`, `ISBN`, `quantity`, `title` ) VALUES ('$userID', '$ISBN', 1,'$book')";
            $this->conn->query($enterPurchase);
            $totalAmount += $price;
        }
        $gatherTotal = "SELECT `total_spent` FROM `customer` WHERE `ID` = '$userID'";
        $rows = $this->conn->query($gatherTotal);
        $totalRow = $rows->fetch_assoc();
        $runningTotal = $totalRow['total_spent'];
        $runningTotal += $totalAmount;

        $updateTotal = "UPDATE `customer` SET `total_spent` = '$runningTotal' WHERE `ID` = '$userID'";
        $this->conn->query($updateTotal);
        
        echo "1";

    }
}




$bookPurchase = new PurchaseBook();
$bookPurchase->purchase();