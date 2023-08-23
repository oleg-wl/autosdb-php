
<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=autodb', 
   'autodb', 'autodb');

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$pass = hash('sha256', 'php123');

?>


