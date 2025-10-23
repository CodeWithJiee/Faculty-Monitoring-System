<?php
include("config.php");
include("firebaseRDB.php");


if (isset($_GET['id'])) {
    $db = new firebaseRDB($databaseURL);
    $id = $_GET['id'];

    if ($id != "") {
        $delete = $db->delete("schedule", $id);
        
        
        header("Location: attendance.php?status=deleted");
        exit(); 
    }
}


header("Location: dashboard.php?status=error");
exit();
?>