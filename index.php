<?php
session_start();
?>
<?php
require_once "pdo.php";

$sql_add = " INSERT INTO autos (make, year, mileage, name) VALUES (:make, :year, :mileage, :name)";
$sql_show = "SELECT autos_id, make, model, year, mileage FROM autos";

?>
<html>
    <title></title>
    <body>
        
        <div class="container">
            <h1>Welcome to Autos Database</h1>
            <?php 
        if (!isset($_SESSION['name'])) {
            echo('<p><a href="login.php">Please Log In</a></p>');
            return;
        } ?>
    <?php
    $show = $pdo->query('SELECT * from autos');
    $row = $show->fetchAll(PDO::FETCH_ASSOC);
    
    //message box
    if (isset($_SESSION['success'])) {
        echo ("<p style='color:green'>" . htmlentities($_SESSION['success']) . "</p>");
        unset($_SESSION['success']);
    }

    //message box
    if (isset($_SESSION['error'])) {
        echo ("<p style='color:red'>" . htmlentities($_SESSION['error']) . "</p>");
        unset($_SESSION['error']);
    }

    //No rows returned
    if (empty($row)) {
        echo ('<p style="color:red">No rows found</p>'."\n");
    } else {

        echo ('<table border="1">' . "\n");
        echo ('<td>Make</td><td>Model</td><td>Year</td><td>Mileage</td><td>Action</td></th>');
        foreach ($row as $r) {
            echo "<tr><td>";
            echo (htmlentities($r['make']));
            echo ("</td><td>");
            echo (htmlentities($r['model']));
            echo ("</td><td>");
            echo (htmlentities($r['year']));
            echo ("</td><td>");
            echo (htmlentities($r['mileage']));
            echo ("</td><td>");
            echo ('<a href="edit.php?id=' . $r['autos_id'] . '">Edit</a> ');
            echo ('<a href="delete.php?id=' . $r['autos_id'] . '">Delete</a>');
            echo ("</td></tr>");
        }
        echo ('</table>');
    }
    echo('<a href="add.php">Add a New Entry</a><br>');
    echo('<a href="logout.php">Log out</a><br>');
    ?>
    </div>
    </body>
</html>