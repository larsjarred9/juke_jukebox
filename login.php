<?php
session_start(); ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>JUKE | Login</title>
    <link href="css/style.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="images/juke_favicon.png" />
</head>

<?php
require_once 'php/database.php';
if (isset($_POST['inlog'])) {
    if ($stmt = $conn->prepare("SELECT id, password FROM users WHERE username=? limit 1")) {
        $stmt->bind_param("s", $_POST['username']);
        $stmt->execute();
        $stmt->bind_result($id, $password);
        $stmt->fetch();
        $stmt->close();
        if ($_POST['password'] == $password) {
            $_SESSION['id'] = $id;
            header("location: dashboard/index.php");
        } else {
            echo '<img src="images/juke.png" class="d-block mx-auto" alt="">';
            echo "<p class='text-white text-center'>Password did not match</p>";
            echo "<center><a class='btn btn-primary' href='login.php'>Try Again</a></center>";
        }
    } else {
        echo '<img src="images/juke.png" alt="">';
        echo "<p class='text-white text-center'>Database Connection failed</p>";
        echo "<center><a class='btn btn-primary' href='login.php'>Try Again</a></center>";
    }
} else {
?>

    <body class="text-center">

        <main class="form-signin container">
            <form method="post" action="login.php">
                <img src="images/juke.png" alt="">
                <h1 class="h3 mb-3 text-white">Login</h1>
                <label for="inputEmail" class="visually-hidden">username</label>
                <input type="text" name="username" id="username" class="form-control mb-3" placeholder="username" required autofocus>
                <label for="inputPassword" class="visually-hidden">password</label>
                <input type="password" name="password" id="password" class="form-control mb-3" placeholder="password" required>

                <button class="w-100 btn btn-lg btn-primary" type="submit" name="inlog">Login</button>
            </form>
        </main>
    <?php } ?>


    </body>

</html>