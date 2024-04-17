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

class userInfo{

    private $conn;
    public function __construct()
    {
        $databaseConnection = new Database();
        $this->conn = $databaseConnection->conn;
    }

    public function DisplayInfo(){

        $name = ($_GET['name']);

        $sql = "SELECT * FROM `customer` WHERE `name` = '$name'";
        $rows = $this->conn->query($sql);
        $results = $rows->fetch_assoc();

        $bookISBNs = "SELECT `ISBN`, `quantity`, `title` FROM `purchases` WHERE `custID` = '" . $results['ID'] . "'";
        $books = $this->conn->query($bookISBNs);

        /*
                        <td>
                    <?php $books->data_seek(0);
                    while ($bookResult = $books->fetch_assoc()) {
                        echo $bookResult['quantity'] . "<br>";
                    }
                    ?>
                </td>
                */


        ?>
        <form method="post" action="return.php" class="form-button">
            <input type="submit" name="act" value="Back">
            <input type="hidden" name="interface" value="6">
        </form>

        <link href="table.css" rel="stylesheet">
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>total Spent</th>
            </tr>
            <tr>
                <td><?=$results['ID']?></td>
                <td><?=$results['name']?></td>
                <td><a href='bookInfo.php?name=<?=$name?>'><?=$results['total_spent']?></a></td>
            </tr>
        </table>

        <div style="margin-top: 20px;"></div>

        <form method="post" action="check.php">
            <label for="displayPassword">Display Password:</label>
            <input type="password" id="displayPassword" name="displayPassword">
            <input type="submit" name="act" value="Display Source">
            <input type="hidden" name="interface" value="6">


        </form>
<?php


    }

}

$userInfo = new userInfo();
$userInfo->DisplayInfo();

?>


</body>
</html>