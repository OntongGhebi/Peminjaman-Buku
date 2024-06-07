<?php 

    include "db/database.php";
    session_start();

    $registrasi_message = "";
    if(isset($_SESSION ["isLogin"])) {
        header("Location: dashboard.php");
    }
    if(isset($_POST['registrasi'])){
        $username = $_POST["username"];
        $password = $_POST["password"];
        $hash_password = hash("sha256", $password);

        try {
            $sql = "INSERT INTO pengguna (username, password) VALUES
                ('$username', '$hash_password')";

            if($db->query($sql)){
                $registrasi_message = "Pendaftaran Berhasil";
            }else {
                $registrasi_message = "Pendaftaran Tidak Berhasil, Mohon Diulangi";    
            }
        }catch (mysqli_sql_exception) {
            $registrasi_message = "Username Telah Digunakan";
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
    <h2>DAFTAR AKUN</h2>
    <i><?= $registrasi_message ?></i>
    <form action="registrasi.php" method="post">
        <input type="text" placeholder="username" name="username"/>
        <input type="password" placeholder="password" name="password"/>
        <button type="submit" name="registrasi">Daftar Sekarang</button>
    </form>
        
    <?php include "Layout/footer.html"?>
</body>
</html>