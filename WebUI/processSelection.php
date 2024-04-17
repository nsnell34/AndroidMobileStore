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

class processSelection
{
    public function processSelection()
    {
        if ($_POST['act'] == 'Back') {
            header("Location: listScreen.html");
        } 

    }
}

$selection = new processSelection;
$selection->processSelection();


?>

</body>
</html>