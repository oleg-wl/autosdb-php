<?php
session_start();
if (!isset($_SESSION['name'])) {
    die('ACCESS DENIED');
} ?>
<?php
require_once "pdo.php";

//DATA VALIDATION
if (isset($_POST["add"])) {
    if (empty($_POST['make']) or empty($_POST['year']) or empty($_POST['mileage']) or empty($_POST['model'])) {
        $_SESSION['error'] = "All fields are required";
        header("Location: add.php");
        return;
    } elseif (!is_numeric($_POST['year'])) {
        $_SESSION['error'] = "Year must be an integer";
        header("Location: add.php");
        return;

    } elseif (!is_numeric($_POST['mileage'])) {
        $_SESSION['error'] = "Mileage must be an integer";
        header("Location: add.php");
        return;
    } else {
        $sql = "INSERT INTO autos(make, model, year, mileage) VALUES (:make, :model, :year, :mileage)";
        $add = $pdo->prepare($sql);
        $add->execute(
            array(
                ':make' => htmlentities($_POST['make']),
                ':year' => htmlentities($_POST['year']),
                ':mileage' => htmlentities($_POST['mileage']),
                ':model' => htmlentities($_POST['model'])
            )
        );
        $_SESSION['success'] = 'Record inserted';
        header('Location: index.php');
        return;
    }
}
?>

<html>
<head>
    <title>55f5410c</title>
</head>

<body>
    <div class="container">
        <form method="post">
            <p>Make:
                <input type="text" name="make" size="60" />
            </p>
            <p>Model:
                <input type="text" name="model" size="60" />
            </p>
            <p>Year:
                <input type="text" name="year" />
            </p>
            <p>Mileage:
                <input type="text" name="mileage" />
            </p>
            <input type="submit" name="add" value="Add New">
            <button><a href="index.php">Cancel</a></button>
        </form>
    <?php if (isset($_SESSION['error'])) {
        echo ("<p style='color:red'>" . htmlentities($_SESSION['error']) . "</p><br>");
        unset($_SESSION['error']);
    }     ?>

    </div>
</body>
</html>