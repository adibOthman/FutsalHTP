<?php
include 'dbconnected.php';

$in      = $conn->query("SELECT SUM(fAmount) AS total FROM transaksi WHERE fType='masuk'")->fetch_assoc()['total'] ?? 0;
$out     = $conn->query("SELECT SUM(fAmount) AS total FROM transaksi WHERE fType='keluar'")->fetch_assoc()['total'] ?? 0;
$balance = $in - $out;
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Futsal HTP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="bg-dark text-white py-2">
<div class="bg-dark text-white py-2">
        <div class="container d-flex justify-content-between align-items-center">
            <img src="images/logo.jpeg" alt="Heitech Padu Futsal Logo" class="logo" style="height: 100px;">

            <h1 class="m-0">Heitech Padu Futsal</h1>
        </div>
    </div>
    </div>
<style>
    :root {
        --heitech-blue: #003366;
        --heitech-orange: #ff6600;
    }

    .custom-footer {
    background-color: var(--heitech-blue);
    border-top: 4px solid var(--heitech-orange);
    border-radius: 8px 8px 0 0;
}

</style>
<div class="container py-5">
    <div class="card shadow">
        <div class="card-body">
            <h2 class="card-title text-center mb-4">📒 Kira-Kira Wang Keluar Masuk</h2>

            <ul class="list-group mb-4">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    💰 Jumlah Masuk:
                    <span class="badge bg-success rounded-pill">RM <?php echo number_format($in, 2); ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    💸 Jumlah Keluar:
                    <span class="badge bg-danger rounded-pill">RM <?php echo number_format($out, 2); ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    💼 Baki Terkini:
                    <span class="badge bg-primary rounded-pill">RM <?php echo number_format($balance, 2); ?></span>
                </li>
            </ul>

            <div class="d-flex justify-content-center gap-3">
                <a href="addRecord.php" class="btn btn-success">+ Tambah Rekod</a>
                <a href="listRecord.php" class="btn btn-outline-primary">📋 Senarai Rekod</a>
            </div>
        </div>
    </div>
</div>
<canvas id="summaryChart" height="100"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('summaryChart').getContext('2d');
    const summaryChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Masuk', 'Keluar', 'Baki'],
            datasets: [{
                label: 'RM',
                data: [<?= $in ?>, <?= $out ?>, <?= $balance ?>],
                backgroundColor: [
                    'rgba(40, 167, 69, 0.6)',   
                    'rgba(220, 53, 69, 0.6)',  
                    'rgba(0, 123, 255, 0.6)' 
                ],
                borderColor: [
                    'rgba(40, 167, 69, 1)',
                    'rgba(220, 53, 69, 1)',
                    'rgba(0, 123, 255, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
</div>
<footer class="custom-footer mt-5 text-white text-center py-3">
    &copy; <?= date('Y') ?> Created by DibO
    <br> 016-8877623
    <br> Futsal HTP V1.0
</footer>

</body>
</html>
