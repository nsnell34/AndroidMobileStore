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

header("Content-type:text/plain; charset=UTF-8");
if ($_POST['act'] == 'MainActivity'){
    $content = file_get_contents("androidTXT/MainActivity.txt");
    echo($content);
} elseif ($_POST['act'] == 'SignInActivity'){
    $content = file_get_contents("androidTXT/SignInActivity.txt");
    echo($content);
} elseif ($_POST['act'] == 'HomeActivity'){
    $content = file_get_contents("androidTXT/HomeActivity.txt");
    echo($content);
} elseif ($_POST['act'] == 'BookActivity'){
    $content = file_get_contents("androidTXT/BookActivity.txt");
    echo($content);
} elseif ($_POST['act'] == 'StoreActivity'){
    $content = file_get_contents("androidTXT/StoreActivity.txt");
    echo($content);
} elseif ($_POST['act'] == 'UserActivity'){
    $content = file_get_contents("androidTXT/UserActivity.txt");
    echo($content);
} elseif ($_POST['act'] == 'PurchaseBook'){
    $content = file_get_contents("androidTXT/PurchaseBook.txt");
    echo($content);
} else {
    echo("No such interface: " . $_POST['act']);
}

?>
</body>
</html>
