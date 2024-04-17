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

class EntryPage {
    public function navigatePage() {

        if ($_POST['act'] == 'Update') {
                header("Location: adminScreen.html");
        } elseif ($_POST['act'] == 'List'){
            header("Location: listScreen.html");
        }
        elseif ($_POST['act'] == 'Sign Out'){
            header("Location: index.html");
        }

    }
}

$entryPage = new EntryPage();
$entryPage->navigatePage();

?>

</body>
</html>