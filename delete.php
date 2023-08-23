<?php 
session_start();
require_once 'pdo.php';
?>

<?php

//Проверка нажатия кнопки делит
if ( isset($_POST['delete']) && isset($_POST['id']) ) {
    $sql = "DELETE FROM autos WHERE autos_id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':id' => $_POST['id']));
    $_SESSION['success'] = 'Record deleted';
    header( 'Location: index.php' ) ;
    return;
}

// Guardian: Make sure that user_id is present
if ( ! isset($_GET['id']) ) {
  $_SESSION['error'] = "Missing id";
  header('Location: index.php');
  return;
}
?>

<?php
$stmt = $pdo->prepare("SELECT * FROM autos WHERE autos_id = :id");
$stmt->execute(array(":id" => $_GET['id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for user_id';
    header( 'Location: index.php' ) ;
    return;
}
?>

<p>Confirm: Deleting <?= htmlentities($row['model']) ?></p>

<form method="post">
<input type="hidden" name="id" value="<?= $row['autos_id'] ?>">
<input type="submit" value="Delete" name="delete">
<a href="index.php">Cancel</a>
</form>