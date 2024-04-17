
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

class Login
{
    private $conn;
    public function __construct()
    {
        $databaseConnection = new Database();
        $this->conn = $databaseConnection->conn;
    }
    public function loginUser()
    {
        $username = strtolower($_POST['name']);

       
        if ($_POST['act'] == 'Enter') {
            if ($username == 'admin') {
                header("Location: enter.html");
                
            } else {
                echo '<script>alert("Admin not found");</script>';
                echo '<script>window.history.back();</script>';
            }


        } elseif ($_POST['act'] == 'Clear System') {
            $sql = file_get_contents('clearTables.sql');
            if ($this->conn->multi_query($sql) === TRUE) {
                echo '<script>alert("Database Cleared.");</script>';
                echo '<script>window.history.back();</script>';
            } else {
                echo "Could not clear system - " . $this->conn->error;
            }
        }

        $this->conn->close();
    }




}

$login = new Login();
$login->loginUser();

?>

</body>
</html>