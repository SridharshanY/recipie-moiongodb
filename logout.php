<?php
// logout.php
session_start();
session_unset();
session_destroy();

// Redirect the user after logout (for example, to the login page)
header("Location: login.php"); // or wherever you want to redirect the user
exit();
?>