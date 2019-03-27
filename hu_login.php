<?php
    require '../database/database.php';
    
    if (session_status() !== PHP_SESSION_ACTIVE) session_start();
    
    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password_hash'];
        $response = array();
        
        $valid = true;
        $response['valid'] = false;
        
		if (empty($username) || empty($password)) {
			$valid = false;
		}         
                
        if ($valid) {
			$pdo = Database::connect();
            $sql = "SELECT * FROM healthyu_users WHERE username = ? AND password_hash = ?";
			$q = $pdo->prepare($sql);
            $q->execute(array($username,$password));
            if ($q->rowCount() == 1) {
                $response['valid'] = true;
                $rec = $q->fetch(PDO::FETCH_ASSOC);
                $_SESSION['id'] = $rec[id];
                $sql = "SELECT * FROM healthyu_admin WHERE userID = ?";
                $q = $pdo->prepare($sql);
                $q->execute(array($rec[id]));
                if ($q->rowCount() == 1) {
                    $_SESSION['admin'] = true;
                } else {
                    $_SESSION['admin'] = false;
                }
            }
			Database::disconnect();
		}
        
        echo json_encode($response);
    }
?>