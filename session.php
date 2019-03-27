<?php
    session_start();
    if ($_SESSION['id'] !== NULL)
        print "active";
    else
        print "expired";
?>