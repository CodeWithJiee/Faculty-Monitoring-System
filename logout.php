<?php
// Start the session to access session data.
session_start();

// Unset all of the session variables.
$_SESSION = array();

// pagka-logout di makakabalik sa dashboard.php pag-click ng arrow
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}


session_destroy();

//balik sa login
header("Location: index.php");
exit();
?>
