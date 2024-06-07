<?php
include 'db/db_buku.php';

// Periksa apakah data formulir ada sebelum digunakan
if (isset($_POST['title']) && isset($_POST['author']) && isset($_POST['available'])) {
    // Sanitasi input
    $title = $conn->real_escape_string($_POST['title']);
    $author = $conn->real_escape_string($_POST['author']);
    $available = (int)$_POST['available'];

    // Gunakan prepared statement untuk mencegah SQL injection
    $stmt = $conn->prepare("INSERT INTO buku (title, author, available) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $title, $author, $available);

    if ($stmt->execute() === TRUE) {
        echo "Buku Berhasil Ditambahkan!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php include "Layout/Input Buku.html" ?>
    
</body>
</html>
