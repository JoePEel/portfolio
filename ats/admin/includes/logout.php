<?php
ob_start();
session_unset();
session_destroy();

header("Location: ../../ats.php")

?>