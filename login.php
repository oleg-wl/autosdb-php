<?php
session_start();
require_once 'pdo.php';

if (isset($_POST['login'])) {
    if (hash('sha256', $_POST['pass']) !== $pass) {
        $_SESSION['error'] = 'Incorrect password';
        header('Location: login.php');
        return;

    } elseif (empty($_POST['email']) or empty($_POST['pass'])) {
        $_SESSION['error'] = 'User name and password are required';
        header('Location: login.php');
        return;

    } elseif (!empty($_POST['email']) && strpos($_POST['email'], '@') == False) {
        $_SESSION['error'] = 'Email must have an at-sign (@)';
        header('Location: login.php');

        error_log("Login fail " . $_POST['email'] . $pass . "\n", message_type: 3, destination: "log.txt");
        return;

    } else {
        $_SESSION['name'] = $_POST['email'];
        $_SESSION['success'] = "Login success";
        header("Location: index.php");

        error_log("Login success " . $_POST['email'] . "\n", message_type: 3, destination: "log.txt");
        return;
    }
}
?>

<html>

<head>
    <title>55f5410c</title>
</head>

<p>Please Log In</p>
<?php
if (isset($_SESSION['error'])) {
    echo ('<p style="color:red">'.htmlentities($_SESSION['error'])."</p>\n");
    unset($_SESSION['error']);
}
?>

<form method="post">
    <p>User Name
        <input type="text" size="44" name="email">
    </p>
    <p>Password
        <input type="text" size="40" name="pass">
    </p>
    <p><input type="submit" name='login' value="Log In" />
        <a href="index.html">Cancel</a>
    </p>
</form>
<p>

</html>