<?php 
require '../database/database.php';
    session_start();
    
    $data = array();
    $id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
    
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM healthyu_transactions WHERE id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    $user_id = $data['user_id'];
    Database::disconnect();
    
    // check for valid session
    $valid = false;
    if ($_SESSION['admin'] === TRUE) {
        $valid = true;
    } else {
        if ($data['user_id'] == $_SESSION['id']) {
            $valid = true;
        }
    }
	
    if ($valid) { 
        $pdo = Database::connect();
        $sql = "SELECT username FROM healthyu_users WHERE id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($user_id));
        $name = $q->fetch(PDO::FETCH_ASSOC);
        Database::disconnect();
    }
?>

<div class="title">HealthyU: Read Transaction</div>
<p>
    <a href="hu_start.html" class="btn btn-primary">Back to Start</a>
</p>
<div class="form-horizontal" >
    <div class="control-group">
        <label class="control-label">user</label>
        <div class="controls">
            <label class="checkbox">
                <?php echo $name['username']; ?>
            </label>
        </div>
    </div>
</div>
<div class="form-horizontal" >
    <div class="control-group">
        <label class="control-label">transtype_id</label>
        <div class="controls">
            <label class="checkbox">
                <?php echo $data['transtype_id']; ?>
            </label>
        </div>
    </div>
</div>
<div class="form-horizontal" >
    <div class="control-group">
        <label class="control-label">trans_date</label>
        <div class="controls">
            <label class="checkbox">
                <?php echo $data['trans_date']; ?>
            </label>
        </div>
    </div>
</div>
<div class="form-horizontal" >
    <div class="control-group">
        <label class="control-label">minutes</label>
        <div class="controls">
            <label class="checkbox">
                <?php echo $data['minutes']; ?>
            </label>
        </div>
    </div>
</div>
<div class="form-horizontal" >
    <div class="control-group">
        <label class="control-label">trans_exercise_points</label>
        <div class="controls">
            <label class="checkbox">
                <?php echo $data['trans_exercise_points']; ?>
            </label>
        </div>
    </div>
</div>
<div class="form-horizontal" >
    <div class="control-group">
        <label class="control-label">trans_points</label>
        <div class="controls">
            <label class="checkbox">
                <?php echo $data['trans_points']; ?>
            </label>
        </div>
    </div>
</div>
<div class="form-horizontal" >
    <div class="control-group">
        <label class="control-label">trans_hu_activity</label>
        <div class="controls">
            <label class="checkbox">
                <?php echo $data['trans_hu_activity']; ?>
            </label>
        </div>
    </div>
</div>
<div class="form-horizontal" >
    <div class="control-group">
        <label class="control-label">trans_strength_activity</label>
        <div class="controls">
            <label class="checkbox">
                <?php echo $data['trans_strength_activity']; ?>
            </label>
        </div>
    </div>
</div>
<div class="form-horizontal" >
    <div class="control-group">
        <label class="control-label">trans_fitness_class</label>
        <div class="controls">
            <label class="checkbox">
                <?php echo $data['trans_fitness_class']; ?>
            </label>
        </div>
    </div>
</div>
<div class="form-actions">
    <a class="btn" href="hu_transactions_list.html">Back</a>
</div>