<div class="title">HealthyU: Users</div>
<a href="hu_users_create.html" class="btn btn-success btn-size">Create</a>
<a href="hu_start.html" class="btn btn-primary btn-size-back">Back to Start</a>
<table class="table table-striped table-bordered" style="margin-top: 2vh">
    <thead>
        <tr>
            <th>Username</th>
            <th>Full Name</th>
            <th>Score</th>
            <th></th>
        </tr>
    <tbody id="tbody">
    </thead>
<?php 
    include 'database.php';
    session_start();
    if ($_SESSION['admin'] === TRUE) {
        $pdo = Database::connect();
        $sql  = 'SELECT HU1.id, HU1.username, HU1.fullname, SUM(HU2.trans_points) AS score ';
        $sql .= 'FROM healthyu_users AS HU1 ';
        $sql .= 'LEFT OUTER JOIN healthyu_transactions AS HU2 ON HU1.id = HU2.user_id ';
        $sql .= 'GROUP BY HU1.username ';
        $sql .= 'ORDER BY HU1.username ASC';
        foreach ($pdo->query($sql) as $row) {
            echo '<tr>';
            echo '<td width="25%">'. $row['username'] . '</td>';
            echo '<td width="25%">'. $row['fullname'] . '</td>';
            echo '<td width="15%">'. $row['score']    . '</td>';
            echo '<td width="20%">';
            echo '<a class="btn btn-size" href="hu_users_read.html?id='.$row['id'].'">Read</a>';
            echo '<a class="btn btn-success btn-size" href="hu_users_update.html?id='.$row['id'].'">Update</a>';
            echo '<a class="btn btn-danger btn-size" href="hu_users_delete.html?id='.$row['id'].'">Delete</a>';
            echo '</td>';
            echo '</tr>';
        }
    }
    Database::disconnect();
?>
    </tbody>
</table>