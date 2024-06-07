<?php
    include "db/database.php";
    session_start();

    $login_message = "";
    if(isset($_SESSION ["isLogin"])) {
        header("Location: dashboard.php");
    }

    if(isset($_POST['login'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $hash_password = hash("sha256", $password);

        $sql = "SELECT * FROM pengguna WHERE username = '$username' 
        AND password = '$hash_password'";

        $result = $db->query($sql);

        if($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            $_SESSION["username"] = $data["username"];
            $_SESSION["isLogin"] = true;

            header("location: dashboard.php");
        }else {
            $login_message = "Akun Tidak Ditemukan";
        }
    }
    $db->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php include "Layout/header.html"?>
    <h2>MASUK AKUN</h2>
    <i><?= $login_message ?></i>
    <form action="login.php" method="post">
        <input type="text" placeholder="username" name="username"/>
        <input type="password" placeholder="password" name="password"/>
        <button type="submit" name="login">Masuk Sekarang</button>
    </form>
        
    <?php include "Layout/footer.html"?>
</body>
</html>