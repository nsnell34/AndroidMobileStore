<html>
<body>

<?php
error_reporting(-1);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL ^ E_WARNING ^ E_DEPRECATED);
ini_set("session.gc_maxlifetime", "180000");

ignore_user_abort(1);
set_time_limit(1800);

include_once('Database.php');

class bookInfo{

    private $conn;
    public function __construct()
    {
        $databaseConnection = new Database();
        $this->conn = $databaseConnection->conn;
    }

    public function DisplayInfo(){

        $name = ($_GET['name']);

        $sqlUser = "SELECT * FROM `customer` WHERE `name` = '$name'";
        $rowsUser = $this->conn->query($sqlUser);
        $resultsUser = $rowsUser->fetch_assoc();
        $userId = $resultsUser['ID'];

        $sql = "SELECT `title` FROM `purchases` WHERE `custID` = '$userId'";
        $rows = $this->conn->query($sql);
        $books = array();
        while ($row = $rows->fetch_assoc()) {
            $books[] = $row;
        }
        
        $books = array_map("unserialize", array_unique(array_map("serialize", $books)));
        

        ?>
        <form method="post" action="return.php" class="form-button">
            <input type="submit" name="act" value="Back">
            <input type="hidden" name="interface" value="7">
        </form>

        
            <link href="table.css" rel="stylesheet">
            <table>
                <tr>
                    <th>Purchased Books</th>
                </tr>
                <?php foreach ($books as $book) { ?>
                <tr>
                    <td><?=$book['title']?></td>
                </tr>
                <?php } ?>
            </table>


        <div style="margin-top: 20px;"></div>

        <form method="post" action="check.php">
            <label for="displayPassword">Display Password:</label>
            <input type="password" id="displayPassword" name="displayPassword">
            <input type="submit" name="act" value="Display Source">
            <input type="hidden" name="interface" value="7">


        </form>
        <?php


    }

}


$bookInfo = new bookInfo();
$bookInfo->DisplayInfo();

?>


</body>
</html>
