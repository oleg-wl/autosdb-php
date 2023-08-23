<?php
session_start();
if (!isset($_SESSION['name']) ) {
  die('ACCESS DENIED');
}?>


<?php
require_once "pdo.php";


if (!empty($_SESSION['name'])) {
    $show = $pdo->prepare($sql_show);
    $show->execute(array(
        ':name' => $_SESSION['name']
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
    <title>55f5410c</title>
</head>

<body>
    <div class="container">
    <h1>Tracking Autos for <?php echo(htmlentities($_SESSION['name'])) ?> </h1>
<?php
if (isset($_SESSION['success'])) {
    echo ("<p style='color:green'>".htmlentities($_SESSION['success'])."</p>");
    unset($_SESSION['success']);
}
?>
        <h2>Automobiles</h2>
        <ul>
            <?php 
                foreach ($row as $r) {
                    echo ( $r['make'] .' '. $r['year'] .''. $r['mileage']."<br>" );
                }
            
            ?>
        </ul>
    </div>
    <p>
<a href="add.php">Add New</a> |
<a href="logout.php">Logout</a>
</p>
</body>

</html>
