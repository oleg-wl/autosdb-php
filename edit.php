<?php
session_start();
require_once 'pdo.php';
if (!isset($_SESSION['name'])) {
    die('ACCESS DENIED');
} ?>

<?php

//DATA VALIDATION
if (isset($_POST["edit"])) {
    if (empty($_POST['make']) or empty($_POST['year']) or empty($_POST['mileage']) or empty($_POST['model'])) {
        $_SESSION['error'] = "All fields are required";
        header("Location: edit.php");
        return;
    } elseif (!is_numeric($_POST['year'])) {
        $_SESSION['error'] = "Year must be an integer";
        header("Location: edit.php");
        return;

    } elseif (!is_numeric($_POST['mileage'])) {
        $_SESSION['error'] = "Mileage must be an integer";
        header("Location: edit.php");
        return;
    } else {
        $sql = 'UPDATE autos SET make = :make, year = :year, mileage = :mileage, model = :model WHERE autos_id = :id';
        $edit = $pdo->prepare($sql);
        $edit->execute(
            array(
                ':make' => $_POST['make'],
                ':year' => $_POST['year'],
                ':mileage' => $_POST['mileage'],
                ':model' => $_POST['model'],
                ':id' => $_POST['id']
            )
        );
        $_SESSION['success'] = "Record edited";
        header('Location:index.php');
        return;
    }
}

// Guardian: Make sure that user_id is present
if ( ! isset($_GET['id']) ) {
  $_SESSION['error'] = "Missing id";
  header('Location: index.php');
  return;
}

$stmt = $pdo->prepare("SELECT * FROM autos WHERE autos_id = :id");
$stmt->execute(array(":id" => $_GET['id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for user_id';
    header( 'Location: index.php' ) ;
    return;
}
?>
<html>
<?php
// Flash pattern
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}
?>
<?php
$make = htmlentities($row['make']);
$mod = htmlentities($row['model']);
$y = htmlentities($row['year']);
$mil = htmlentities($row['mileage']);
$id = $row['autos_id'];
?>
<head>
    <title>55f5410c</title>
</head>

<body>
    <div class="container">
        <form method="post">
            <p>Make:
                <input type="text" name="make" size="60" value="<?= $make ?>" />
            </p>
            <p>Model:
                <input type="text" name="model" size="60" value="<?= $mod ?>"/>
            </p>
            <p>Year:
                <input type="text" name="year" value="<?= $y ?>"/>
            </p>
            <p>Mileage:
                <input type="text" name="mileage" value="<?= $mil ?>"/>
            </p>
            <input type="hidden" name="id" value="<?= $id ?>">
            <input type="submit" value="Update" name='edit'>
            <button><a href="index.php">Cancel</a></button>
        </form>
</html>