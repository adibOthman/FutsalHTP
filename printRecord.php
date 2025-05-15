<?php
include 'dbconnected.php';

$result = $conn->query("SELECT * FROM transaksi ORDER BY fDate DESC");

$in  = $conn->query("SELECT SUM(fAmount) AS total FROM transaksi WHERE fType='masuk'")->fetch_assoc()['total'] ?? 0;
$out = $conn->query("SELECT SUM(fAmount) AS total FROM transaksi WHERE fType='keluar'")->fetch_assoc()['total'] ?? 0;
$balance = $in - $out;
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Senarai Rekod (Cetak)</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h2, h3 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 8px;
            border: 1px solid #ccc;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        .summary {
            margin-top: 30px;
        }

        .summary li {
            font-size: 16px;
        }
        @media print {
            .no-print {
                display: none;
            }
            body {
                margin: 0;
                padding: 0;
            }
            table, th, td {
                border: 2px solid black; 
            }
            th {
                background-color: #f4f4f4; 
            }
            td {
                padding: 10px; 
            }
        }
    </style>
</head>
<body>

<h2>Senarai Rekod Simpanan</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Tarikh</th>
        <th>Jenis</th>
        <th>Amaun (RM)</th>
        <th>Keterangan</th>
    </tr>

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['fDate']}</td>";
            echo "<td>{$row['fType']}</td>";
            echo "<td>" . number_format($row['fAmount'], 2) . "</td>";
            echo "<td>{$row['fDesc']}</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='5'>Tiada rekod ditemui.</td></tr>";
    }
    ?>
</table>
<div class="summary">
    <h3>Ringkasan:</h3>
    <ul>
        <li>Jumlah Masuk: RM <?php echo number_format($in, 2); ?></li>
        <li>Jumlah Keluar: RM <?php echo number_format($out, 2); ?></li>
        <li><strong>Baki Terkini: RM <?php echo number_format($balance, 2); ?></strong></li>
    </ul>
</div>
<div class="text-center no-print">
    <button onclick="window.print()">🖨️ Cetak</button>
    <a href="listrecord.php" class="btn btn-secondary">Kembali ke Senarai Rekod</a>
</div>

</body>
</html>
