<?php 
	require 'database.php';
    session_start();
	
    $id = $_REQUEST['id'];
    
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM healthyu_transactions WHERE id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    $user_id = $data['user_id'];
    $transtype_id = $data['transtype_id'];
    $trans_date = $data['trans_date'];
    $trans_points = $data['trans_points'];
    $trans_exercise_points = $data['trans_exercise_points'];
    $trans_hu_activity = $data['trans_hu_activity'];
    $trans_strength_activity = $data['trans_strength_activity'];
    $trans_fitness_class = $data['trans_fitness_class'];
    $minutes = $data['minutes'];
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
        // if data was entered by the user
        if (isset($_POST['update'])) {
            // get values
            $id = $_POST['id'];
            $user_id = $_POST['user_id'];
            $transtype_id = $_POST['transtype_id'];
            $trans_date = $_POST['trans_date'];
            $trans_points = $_POST['trans_points'];
            $trans_exercise_points = $_POST['trans_exercise_points'];
            $trans_hu_activity = $_POST['trans_hu_activity'];
            $trans_strength_activity = $_POST['trans_strength_activity'];
            $trans_fitness_class = $_POST['trans_fitness_class'];
            $minutes = $_POST['minutes'];
            
            $validate = true;
            if (empty($user_id) || empty($transtype_id)) {
                $validate = false;
            } 
            
            // update data
            if ($validate) {
                $pdo = Database::connect();
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "UPDATE healthyu_transactions set user_id = ?, transtype_id = ?, trans_date = ?, trans_points = ?, minutes = ?, trans_exercise_points = ?, trans_hu_activity = ?, trans_strength_activity = ?, trans_fitness_class = ? WHERE id = ?";
                $q = $pdo->prepare($sql);
                $q->execute(array($user_id,$transtype_id,$trans_date,$trans_points,$minutes, $trans_exercise_points, $trans_hu_activity, $trans_strength_activity, $trans_fitness_class, $id));
                Database::disconnect();
            }
        }
    }
?>

<div class="title">HealthyU: Update Transaction</div>
<p><a href="hu_start.html" class="btn btn-primary">Back to Start</a></p>
<div class="control-group <?php echo !empty($user_idError)?'error':'';?>">
    <label class="control-label">user_id</label>
    <div class="controls">
        <?php
            if ($valid) {
                $pdo = Database::connect();
                $sql = 'SELECT * FROM healthyu_users ORDER BY username ASC';
                echo "<select class='form-control' name='user_id' id='user_id'";
                if ($_SESSION['admin'] === FALSE) echo "disabled";
                echo ">";
                foreach ($pdo->query($sql) as $row) {
                    $selected = "";
                    if ($row['id'] == $user_id) $selected = "selected";
                    echo "<option value='" . $row['id'] . " '". $selected. "> " . 
                        trim($row['username']) . " (" . 
                        trim($row['fullname']) . ") " .
                        "</option>";
                }
                echo "</select>";
                Database::disconnect();
            }
        ?>
    </div>
</div>
<div class="control-group <?php echo !empty($transtype_idError)?'error':'';?>">
    <label class="control-label">transtype_id</label>
    <div class="controls">
        <?php
            if ($valid) {
                $pdo = Database::connect();
                $sql = 'SELECT * FROM healthyu_transtypes ORDER BY description ASC';
                echo "<select class='form-control' name='transtype_id' id='transtype_id'>";
                foreach ($pdo->query($sql) as $row) {
                    $selected = "";
                    if ($row['id'] == $transtype_id) $selected = "selected";
                    $hu = "";
                    $strength = "";
                    $fitness = "";
                    if($row['hu_activity']==1) $hu = ", hu_activity";
                    if($row['strength_activity']==1) $strength = ", strength";
                    if($row['fitness_class']==1) $fitness = ", fitness";
                    echo "<option value='" . $row['id'] . " '". $selected. "> " . 
                        trim($row['description']) . " (" . 
                        trim($row['points']) . trim($hu) . trim($strength) . ") " .
                        "</option>";
                }
                echo "</select>";
                Database::disconnect();
            }
        ?>
    </div>
</div>
<div class="control-group <?php echo !empty($trans_dateError)?'error':'';?>">
    <label class="control-label">trans_date</label>
    <div class="controls">
        <input type="date" id="trans_date" name="trans_date" placeholder="date" value="<?php echo !empty($trans_date)?$trans_date:'';?>" required>
    </div>
</div>
<div class="control-group <?php echo !empty($minutesError)?'error':'';?>">
    <label class="control-label">minutes</label>
    <div class="controls">
        <input  type="number" name="minutes"  id="minutes" placeholder="minutes" value="<?php echo !empty($minutes)?$minutes:'';?>" onkeyup="calcExercisePoints()" min="0" required>
    </div>
</div>
<div class="control-group">
    <label class="control-label">trans_exercise_points</label>
    <div class="controls">
        <input type="text" name="trans_exercise_points" id="trans_exercise_points" value="0" readonly>
    </div>
</div>
<div class="control-group">
    <label class="control-label">trans_points</label>
    <div class="controls">
        <input type="text" name="trans_points" id="trans_points" value="0" readonly>
    </div>
</div>
<div class="control-group">
    <label class="control-label">trans_hu_activity</label>
    <div class="controls">
        <input type="checkbox" name="trans_hu_activity" id="trans_hu_activity" onclick="trans_hu_activity_click();calcExercisePoints();" <?php echo !empty($trans_hu_activity)?'checked':'';?> >
    </div>
</div>
<div class="control-group">
    <label class="control-label">trans_strength_activity</label>
    <div class="controls">
        <input type="checkbox" name="trans_strength_activity" id="trans_strength_activity" onclick="trans_strength_activity_click();calcExercisePoints();" <?php echo !empty($trans_strength_activity)?'checked':'';?> >
    </div>
</div>
<div class="control-group">
    <label class="control-label">trans_fitness_class</label>
    <div class="controls">
        <input type="checkbox" name="trans_fitness_class" id="trans_fitness_class" onclick="trans_fitness_class_click();calcExercisePoints();" <?php echo !empty($trans_fitness_class)?'checked':'';?> >
    </div>
</div>