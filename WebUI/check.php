<?php

session_start();
$_SESSION['password'] = $_POST['displayPassword'];
?>

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
//var_dump($_POST);

if ($_POST['act'] == 'Display Source') {
    if ($_SESSION['password'] == 'sioux1234') {

        header("Content-type:text/plain; charset=UTF-8");
        if ($_POST['interface'] == '1') {
            $content = file_get_contents("login.php");
            echo($content);
        } elseif ($_POST['interface'] == '2') {
            $content = file_get_contents("entryPage.php");
            echo($content);
        } elseif ($_POST['interface'] == '3') {
            $content = file_get_contents("adminPage.php");
            echo($content);
        } elseif ($_POST['interface'] == '4') {
            $content = file_get_contents("ListPage.php");
            echo($content);
        } elseif ($_POST['interface'] == '5') {
            $content = file_get_contents("processSelection.php");
            echo($content);
            $content2 = file_get_contents("bookRetrieval.php");
            echo($content2);
        }elseif ($_POST['interface'] == '6') {
            $content = file_get_contents("userInfo.php");
            echo($content);
        } elseif ($_POST['interface'] == '7') {
            $content = file_get_contents("bookInfo.php");
            echo($content);
        }else {
            echo("No such interface: " . $_POST['interface']);
        }

    } 
} elseif ($_POST['act'] == 'Display Android'){

    if($_POST['displayPassword'] == 'sioux1234'){
        header("Location: android.html");

    } else {
        echo '<script>alert("Incorrect Password");</script>';
        echo '<script>window.history.back();</script>';
    }
}
?>

</body>
</html>