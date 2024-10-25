<?php
session_start();
session_destroy();
header("Location: lo.php");
exit;
?>
