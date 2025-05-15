<?php
include 'dbconnected.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fDate   = $_POST['arDate'];
    $fType   = $_POST['arType'];
    $fAmount = $_POST['arAmount'];
    $fDesc   = $_POST['arDesc'];

    $sql = "INSERT INTO transaksi(fDate, fType, fAmount, fDesc)
    VALUES ('$fDate', '$fType', '$fAmount', '$fDesc')";


    if ($conn->query($sql) === TRUE) {
        echo "Muat naik berjaya<br>";
        echo "<a href='index.php'>Kembali ke Utama</a>";
    } else {
        echo "Ralat SQL: " . $conn->error;
    }
    $conn->close();
}
?>