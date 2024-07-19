<?php
    session_start();
    session_destroy();
    header("location: ../Login_y_register.php");

?>