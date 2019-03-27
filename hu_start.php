<?php
    session_start();
    if ($_SESSION['admin'] === TRUE) {
        echo '
            <a href="hu_users_list.html" class="btn btn-success btn-start">
                <div class="center">
                    Users
                </div>
            </a>
            <a href="hu_transtypes_list.html" class="btn btn-success btn-start">
                <div class="center">
                    Transaction Types
                </div>
            </a>';
    }
?>