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
class adminPage
{
    private $conn;
    public function __construct()
    {
        $databaseConnection = new Database();
        $this->conn = $databaseConnection->conn;
    }

    public function NavigatePage()
    {
        $title = ($_POST['Title']);
        $ISBN = ($_POST['ISBN']);
        $price = ($_POST['Price']);

        if ($_POST['act'] == 'Enter') {

            $result = $this->CheckInput($ISBN, $title, $price);

            if ($result == 1){
                $roundedPrice = round($price, 2);
                $this->EnterBook($ISBN, $title, $roundedPrice);
                echo '<script>window.history.back();</script>';
            }

            $this->conn->close();
        }
        elseif ($_POST['act'] == 'Back'){
             print_r($_POST);
            header("Location: enter.html");
        }

    }

    public function EnterBook($ISBN, $title, $price){
        $sql = "INSERT INTO `book` (`ISBN`, `title`, `price` ) VALUES ('$ISBN', '$title', '$price')";

        if ($this->conn->query($sql) === TRUE) {
            echo '<script>alert("Book Entered!");</script>';
        } else {
            echo "Error: " . $sql . "<br>" . $this->conn->error;
        }

    }

    public function CheckInput($ISBN, $title, $price){
        $flag = 1;

        if (strlen($ISBN) == 0 || strlen($title) == 0 || strlen($price) == 0){
            echo('<script>alert("All fields must be entered!")</script>');
            echo '<script>window.history.back();</script>';
            $flag = 0;
        }
        if (strlen($ISBN) != 10){
            echo('<script>alert("ISBN length must be 10")</script>');
            echo '<script>window.history.back();</script>';
            $flag = 0;
        }
        if (!is_numeric($price)){
            echo('<script>alert("Price must be a number")</script>');
            echo '<script>window.history.back();</script>';
            $flag = 0;
        }
        $query = "SELECT `ISBN` FROM `book` WHERE `ISBN` = '$ISBN'";
        $result = $this->conn->query($query);
        if ($result !== false && $result->num_rows > 0) {
            echo('<script>alert("This ISBN has already been entered!")</script>');
            echo '<script>window.history.back();</script>';
            $flag = 0;
        }
        return $flag;

    }


}
$adminPage = new adminPage();
$adminPage->NavigatePage();
?>

</body>
</html>