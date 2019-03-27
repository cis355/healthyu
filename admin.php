<?php
    session_start();
    if ($_SESSION['admin'] == TRUE)
        print "true";
    else
        print "false";
?>