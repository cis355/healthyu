<?php 
	require 'database.php';
	
    session_start();
    if ($_SESSION['admin'] === TRUE) {
        $id = null;
        if (!empty($_GET['id'])) {
            $id = $_REQUEST['id'];
        }
        
        if ( null==$id ) {
            header("Location: hu_users_list.html");
        } else {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM healthyu_users where id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($id));
            $data = $q->fetch(PDO::FETCH_ASSOC);
            Database::disconnect();
        }
    }
?>

<div class="title">HealthyU: User Details</div>
<p>
    <a href="hu_start.html" class="btn btn-primary font-size">Back to Start</a>
</p>
<div class="form-horizontal" >
    <div class="control-group">
        <label class="control-label">username</label>
        <div class="controls">
            <label class="checkbox">
                <?php echo $data['username']; ?>
            </label>
        </div>
    </div>
</div>
<div class="form-horizontal" >
    <div class="control-group">
        <label class="control-label">fullname</label>
        <div class="controls">
            <label class="checkbox">
                <?php echo $data['fullname']; ?>
            </label>
        </div>
    </div>
</div>
<div class="form-actions">
    <a class="btn" href="hu_users_list.html">Back</a>
</div>