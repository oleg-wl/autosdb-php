<?php
if (!isset($_GET['name'])) {
    die("Name parameter missing");
} elseif (isset($_SESSION['error'])) {
    echo ("<p style='color:green'>".htmlentities($_SESSION['error'])."</p>");
    unset($_SESSION['error']);
}
?>

<?php
require_once "pdo.php";

$sql_show = "SELECT make, year, mileage FROM autos WHERE name = :name";
$sql_add = " INSERT INTO autos (make, year, mileage, name) VALUES (:make, :year, :mileage, :name)";
$message = "";


//DATA VALIDATION
if (isset($_POST["add"])) {
    if (!is_numeric($_POST['year']) or !is_numeric($_POST['mileage'])) {
        $message = "Mileage and year must be numeric";
    } elseif (empty($_POST['make'])) {
        $message = "Make is required";
    }     
     else {
        $add = $pdo->prepare($sql_add);
        $add->execute(array(
            ':make' => htmlentities($_POST['make']),
            ':year' => htmlentities($_POST['year']),
            ':mileage' => htmlentities($_POST['mileage']),
            ':name' => $_GET['name']
        ));
        $message = 'Record inserted';
    }
}


if (!empty($_GET['name'])) {
    $show = $pdo->prepare($sql_show);
    $show->execute(array(
        ':name' => $_GET['name']
    ));
    $row = $show->fetchAll(PDO::FETCH_ASSOC);
};

?>

<?php if (isset($_POST['logout'])) {
    header('Location: index.html');
} ?>

<!DOCTYPE html>
<html>

<head>
    <title>Automobile Tracker</title>
    <style> p.err{
        color: red;
    }
    </style>
    <title>c71ca24f</title>
</head>

<body>
    <div class="container">
    <h1>Tracking Autos for <?php echo(htmlentities($_GET['name'])) ?> </h1>
<?php
            if (!empty($message)) {
                echo ("<p class='err'> ".$message."</p>");
            }
?>
        <p> BTW I've used htmlentities function above :* </p>
        <form method="post">
            <p>Make:
                <input type="text" name="make" size="60" />
            </p>
            <p>Year:
                <input type="text" name="year" />
            </p>
            <p>Mileage:
                <input type="text" name="mileage" />
            </p>
            <p>URL:
                <input type="text" name="url"  />
            </p>
            <input type="submit" name="add" value="Add">
            <input type="submit" name="logout" value="Logout">
        </form>

        <h2>Automobiles</h2>
        <ul>
            <?php 
                foreach ($row as $r) {
                    echo ( $r['make'] . $r['year'] . $r['mileage'] );
                }
            
            ?>
        </ul>
    </div>
</body>

</html>
