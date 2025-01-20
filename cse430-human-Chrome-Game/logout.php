<?php
session_start();
session_destroy();
header("Location: successlogout.php");
exit();
?>