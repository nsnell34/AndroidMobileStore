<?php
error_reporting(-1);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL ^ E_WARNING ^ E_DEPRECATED);
ini_set("session.gc_maxlifetime", "180000");

ignore_user_abort(1);
set_time_limit(1800);

include_once('Database.php');
class bookRetrieval
{
    private $conn;
    public function __construct()
    {
        $databaseConnection = new Database();
        $this->conn = $databaseConnection->conn;
    }
    public function showBooks()
    {
        $sql = "SELECT * FROM `book`";

        $result = $this->conn->query($sql);
        ?>
        <link href="table.css" rel="stylesheet">

        <form method="post" action="processSelection.php" >
            <table>
                <tr>
                    <th>Title</th>
                    <th>ISBN</th>
                    <th>Price</th>
                </tr>

                <?php
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?= $row['title'] ?></td>
                        <td><?= $row['ISBN'] ?></td>
                        <td>$<?= number_format($row['price'], 2) ?></td>
                    </tr>
                    <?php
                }
                ?>
            </table>

            <input type="submit" name='act' value="Back">

        </form>

        <div style="margin-top: 20px;"></div>

        </form>
        <form method="post" action="check.php">
            <label for="displayPassword">Display Password:</label>
            <input type="password" id="displayPassword" name="displayPassword">
            <input type="submit" name="act" value="Display Source">
            <input type="hidden" name="interface" value="5">


        </form>

        <?php
        $this->conn->close();
    }
}
$books = new bookRetrieval();
$books->showBooks();


?>