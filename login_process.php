<?php
session_start();


include("config.php");
include("firebaseRDB.php");


$db = new firebaseRDB($databaseURL);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    
    $username = trim($_POST['username']);
    $password = $_POST['password'];


    $result = $db->retrieve("admins"); 
    $all_admins = json_decode($result, 1);

    $user_found = false;

   
    if (is_array($all_admins)) {
        
       
        foreach ($all_admins as $admin_data) {
            
           
            if ($admin_data['username'] == $username && $admin_data['password'] == $password) {
                
                //pasok sa index.php
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['username'] = $admin_data['username'];
                $user_found = true;
                
               
                header("Location: dashboard.php");
                exit();
            }
        }
    }


    if (!$user_found) {
        $_SESSION['login_error'] = "Invalid username or password.";
        header("Location: index.php");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>
