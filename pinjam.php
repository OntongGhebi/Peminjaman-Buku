<?php
include 'db/database.php';

// Periksa apakah data formulir ada sebelum digunakan
if (isset($_POST['book_id']) && isset($_POST['member_id'])) {
    // Sanitasi input
    $book_id = (int)$_POST['book_id'];
    $member_id = (int)$_POST['member_id'];

    // Gunakan prepared statement untuk mencegah SQL injection
    $stmt = $db->prepare("SELECT available FROM buku WHERE id = ?");
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row && $row['available'] > 0) {
        // Lakukan transaksi
        $stmt = $db->prepare("INSERT INTO transactions (book_id, member_id, borrow_date, status) VALUES (?, ?, NOW(), 'borrowed')");
        $stmt->bind_param("ii", $book_id, $member_id);
        if ($stmt->execute() === TRUE) {
            // Kurangi jumlah buku yang tersedia
            $stmt = $db->prepare("UPDATE buku SET available = available - 1 WHERE id = ?");
            $stmt->bind_param("i", $book_id);
            $stmt->execute();
            echo "Buku Berhasil Dipinjam!";
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Buku Tidak Ditemukan atau Tidak Tersedia!";
    }

    $stmt->close();
} else {
    
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
    <h2>Silahkan Masukkan Buku yang Akan Dipinjam</h2>
    <?php include "layout/pinjam.html" ?>
</body>
</html>