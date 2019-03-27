<?php
    // deletes all contents from the transactions table
    include 'database.php';
    $pdo = Database::connect();
    // $sql = 'TRUNCATE TABLE healthyu_transactions';
    $sql = 'SELECT * FROM healthyu_users WHERE username="TEST"';
    $pdo->query($sql);

    $pdo = Database::connect();
    $sql = "SELECT * FROM healthyu_users WHERE username = ? AND password_hash = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array("test","test"));
    if ($q->rowCount() == 1) {
        $rec = $q->fetch(PDO::FETCH_ASSOC);
        $sql = "SELECT * FROM healthyu_admin WHERE userID = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($rec[id]));
        print_r($rec['id']);
        print_r($q->fetch(PDO::FETCH_ASSOC));
        if ($q->rowCount() == 1) {
            echo "true";
        } else {
            echo "false";
        }
    }
    
    Database::disconnect();
?>