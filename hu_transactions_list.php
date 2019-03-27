<?php
include 'database.php';
session_start();
$pdo = Database::connect();
if ($_GET['id'] == "undefined") 
    $id = $_SESSION['id'];
else 
    $id = $_GET['id'];
?>
<div class="title">
    HealthyU: Transactions
</div>
<div style="font-weight: bold; display: inline;">
    Transactions
</div>
<div style="display: inline; margin-bottom: 3vh;">
    include any and all events that might affect the calculation of HealthyU rewards, including all transaction types (transtypes): exercise minutes, HealthyU activities, fitness classes, etc.
</div>
<div style="margin-top: 3vh; margin-bottom: 3vh;">
    <a href="hu_transactions_create.html" class="btn btn-success btn-size">Create</a>
    <a href="hu_start.html" class="btn btn-primary btn-size-back">Back to Start</a>
    <div style="display: inline; text-align:right;">
        
<?php
if ($_SESSION['admin'] === TRUE) {
    $sql = 'SELECT * FROM healthyu_users ORDER BY username ASC';
    echo "<span style='float:right; font-weight:bold;'>Select User: ";
    echo "<select class='form-control' name='user_id' id='user_id' onChange='selectUser()'>";
    echo " <option disabled selected> -- select user -- </option> ";
    foreach ($pdo->query($sql) as $row) {
        echo "<option value='" . $row['id'] ."'";
        if ($row['id'] == $id) echo " selected";
        echo "> " . trim($row['username']) . " (" . trim($row['fullname']) . ") </option>";
    }
    echo "</select>";
}
?>
        </span>
    </div>
</div>
<table class="table table-striped table-bordered">
    <thead>
        <tr>
          <th>User</th>
          <th>Type</th>
          <th>Date</th>
          <th>Points</th>
          <th>Minutes</th>
          <th></th>
        </tr>
    </thead>
    <tbody>
<?php 
$sql  = 'SELECT * FROM healthyu_transactions AS HU1 '; 
$sql .= 'INNER JOIN healthyu_users AS HU2 ON HU1.user_id = HU2.id ';
$sql .= 'INNER JOIN healthyu_transtypes AS HU3 ON HU1.transtype_id = HU3.id ';
$sql .= 'WHERE HU1.user_id = ' . $id;
foreach ($pdo->query($sql) as $row) {
    echo '<tr>';
    echo '<td width="15%">'. $row['username'] . '</td>';
    echo '<td width="13%">'. $row['description'] . '</td>';
    echo '<td width="13%">'. $row['trans_date'] . '</td>';
    echo '<td width="5%">'. $row['trans_points'] . '</td>';
    echo '<td width="5%">'. $row['minutes'] . '</td>';
    echo '<td width="20%">';
    echo '<a class="btn btn-size" href="hu_transactions_read.html?id='.$row[0].'">Read</a>';
    echo '<a class="btn btn-success btn-size" href="hu_transactions_update.html?id='.$row[0].'">Update</a>';
    echo '</td></tr>';
}
Database::disconnect();
?>
    </tbody>
</table>