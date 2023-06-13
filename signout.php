<?php
include 'connect.php';
include 'header.php';


session_destroy();

echo 'Έχετε αποσυνδεθεί. <a href="signin.php"> Συνδεθείτε ξανά </a>';

include 'footer.php';


?>