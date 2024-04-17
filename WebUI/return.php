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

if ($_POST['act'] == 'Back') {
    if ($_POST['interface'] == 1){
        header("Location: index.html");
    } elseif ($_POST['interface'] == 2) {
        $name = $_POST['name'];
        $password = $_POST['password'];
        header("Location: enter.html");
    } elseif ($_POST['interface'] == 3) {
        $name = $_POST['name'];
        $password = $_POST['password'];
        header("Location: listScreen.html");
    } elseif ($_POST['interface'] == 4) {
        $name = $_POST['name'];
        $password = $_POST['password'];
        header("Location: listScreen.html");
    } elseif ($_POST['interface'] == 5) {
        $name = $_POST['name'];
        $password = $_POST['password'];
        header("Location: listScreen.html");
    }
    elseif ($_POST['interface'] == 6) {
        $name = $_POST['name'];
        $password = $_POST['password'];
        header("Location: listScreen.html");
    } elseif ($_POST['interface'] == 7) {
        $name = $_POST['name'];
        $password = $_POST['password'];
        header("Location: listScreen.html");
    } elseif($_POST['interface'] == 8) {
        header("Location: index.html");
    } else {
        echo("No such interface: " . $_POST['interface']);
    }

}

?>

</body>
</html>