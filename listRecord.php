<?php
include 'dbconnected.php';



$filterQuery = "";
$monthLetters = [
    '01' => 'A0',
    '02' => 'B0',
    '03' => 'C0',
    '04' => 'D0',
    '05' => 'E0',
    '06' => 'F0',
    '07' => 'G0',
    '08' => 'H0',
    '09' => 'I0',
    '10' => 'J0',
    '11' => 'K0',
    '12' => 'L0'
];


if (!empty($_GET['month'])) {
    $month = intval($_GET['month']);
    $filterQuery .= " AND MONTH(fDate) = $month";
}

if (!empty($_GET['year'])) {
    $year = intval($_GET['year']);
    $filterQuery .= " AND YEAR(fDate) = $year";
}

$inFilter  = $conn->query("SELECT SUM(fAmount) AS total FROM transaksi WHERE fType='masuk' $filterQuery")->fetch_assoc()['total'] ?? 0;
$outFilter = $conn->query("SELECT SUM(fAmount) AS total FROM transaksi WHERE fType='keluar' $filterQuery")->fetch_assoc()['total'] ?? 0;
$balanceFilter = $inFilter - $outFilter;

$in  = $conn->query("SELECT SUM(fAmount) AS total FROM transaksi WHERE fType='masuk'")->fetch_assoc()['total'] ?? 0;
$out = $conn->query("SELECT SUM(fAmount) AS total FROM transaksi WHERE fType='keluar'")->fetch_assoc()['total'] ?? 0;
$balance = $in - $out;

$sort = ($_GET['sort'] ?? 'asc') === 'asc' ? 'asc' : 'desc';
$nextSort = $sort === 'asc' ? 'desc' : 'asc';

$result = $conn->query("SELECT * FROM transaksi WHERE 1 $filterQuery ORDER BY fDate $sort");
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Senarai Rekod</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
   <style>
    body {
        background-color:rgb(221, 225, 230);
        font-family: Arial, sans-serif;
    }
    :root {
        --heitech-blue: #003366;
        --heitech-orange: #ff6600;
    }
    h2 {
        color: var(--heitech-blue);
        font-weight: bold;
    }
    .btn-primary {
        background-color: var(--heitech-blue);
        border-color: var(--heitech-blue);
    }
    .btn-primary:hover {
        background-color: var(--heitech-orange);
        border-color: var(--heitech-orange);
    }
    .btn-outline-secondary {
        border-color: var(--heitech-blue);
        color: var(--heitech-blue);
    }
    .btn-outline-secondary:hover {
        background-color: var(--heitech-blue);
        color: white;
    }
    .table thead {
        background-color: var(--heitech-blue);
        color: white;
    }
    .summary-card .card-title {
        color: var(--heitech-blue);
    }
    .card.border-success {
        border-color: var(--heitech-blue) !important;
    }
    .card.border-danger {
        border-color: var(--heitech-orange) !important;
    }
    .card.border-primary {
        border-color: var(--heitech-blue) !important;
    }
    .card-text.text-success {
        color: var(--heitech-blue) !important;
    }
    .card-text.text-danger {
        color: var(--heitech-orange) !important;
    }
    .btn-outline-primary {
        color: var(--heitech-orange);
        border-color: var(--heitech-orange);
    }
    .btn-outline-primary:hover {
        background-color: var(--heitech-orange);
        color: white;
    }
    .input-group-text {
        background-color: var(--heitech-blue);
        color: white;
        border-color: var(--heitech-blue);
    }
    .custom-footer {
        background-color: var(--heitech-blue);
        border-top: 4px solid var(--heitech-orange);
        border-radius: 8px 8px 0 0;
    }

</style>
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4 text-center">📋 Senarai Rekod Simpanan</h2>
    <form method="GET" class="mb-4 d-flex justify-content-center">
        <div class="input-group w-auto">
            <label for="month" class="input-group-text">Bulan:</label>
            <select name="month" id="month" class="form-select">
                <option value="">-- Semua Bulan --</option>
                <?php for ($m=1; $m<=12; $m++): ?>
                    <option value="<?= $m ?>" <?= ($_GET['month'] ?? '') == $m ? 'selected' : '' ?>>
                        <?= date('F', mktime(0, 0, 0, $m, 10)) ?>
                    </option>
                <?php endfor; ?>
            </select>
            
            <label for="year" class="input-group-text">Tahun:</label>
            <select name="year" id="year" class="form-select">
                <option value="">-- Semua Tahun --</option>
                <?php
                $startYear = 2024; 
                $currentYear = date('Y');
                for ($y = $startYear; $y <= $currentYear; $y++): ?>
                    <option value="<?= $y ?>" <?= ($_GET['year'] ?? '') == $y ? 'selected' : '' ?>><?= $y ?></option>
                <?php endfor; ?>
            </select>

            <button type="submit" class="btn btn-outline-primary">🔍 Tapis</button>
        </div>
    </form>
        <table class="table table-bordered table-hover bg-white text-center">
            <thead class="table-light text-center">
                    <tr>
                        <th>ID</th>
                        <th>Tarikh</th>
                        <th>Transaksi</th>
                        <th>Amaun (RM)</th>
                        <th>Baki (RM)</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
            <?php
        if ($result->num_rows > 0) {
            $runningBalance = 0; 

            while ($row = $result->fetch_assoc()) {
                $amount = (float)$row['fAmount'];
                $transactionTypeClass = ''; 

                
                if ($row['fType'] === 'masuk') {
                    $transactionTypeClass = 'text-success'; 
                    $runningBalance += $amount;
                } elseif ($row['fType'] === 'keluar') {
                    $transactionTypeClass = 'text-danger';
                    $runningBalance -= $amount;
                }

                echo "<tr>";
                echo "<td>{$row['id']}</td>";
                echo "<td>{$row['fDate']}</td>";
                echo "<td class='{$transactionTypeClass}'>" . ucfirst($row['fType']) . "</td>"; 
                echo "<td>" . number_format($amount, 2) . "</td>";
                echo "<td><strong>" . number_format($runningBalance, 2) . "</strong></td>"; 
                echo "<td>" . htmlspecialchars($row['fDesc']) . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>Tiada rekod ditemui.</td></tr>";
        }
            ?>
                </tbody>
            </table>

    <div class="text-center mt-4">
        <a href="index.php" class="btn btn-outline-secondary">⬅ Utama</a>
        <a href="addRecord.php" class="btn btn-primary">+ Tambah Rekod Baru</a>
        <!-- <a href="printRecord.php" class="btn btn-primary">🖨️ Cetak Rekod</a>  -->
    </div>
            <br>
    <div class="row summary-card">
        <div class="col-md-4">
            <div class="card border-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Jumlah Masuk Keseluruhan (2025)</h5>
                    <p></p>
                    <p class="card-text text-success fw-bold">RM <?= number_format($in, 2) ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-danger mb-3">
                <div class="card-body">
                    <h5 class="card-title">Jumlah Keluar Keseluruhan (2025)</h5>
                    <p></p>
                    <p class="card-text text-danger fw-bold">RM <?= number_format($out, 2) ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Baki Terkini</h5>
                    <p></p>
                    <p class="card-text fw-bold">RM <?= number_format($balanceFilter, 2) ?></p>
                </div>
            </div>
        </div>
</div>

<br>
<?php
    setlocale(LC_TIME, 'ms_MY.UTF-8'); 
    date_default_timezone_set('Asia/Kuala_Lumpur'); // Pastikan zon masa betul
    $currentDate = strftime("%d %B %Y, %H:%M:%S");
?>
<p>Setakat <?= $currentDate ?></p>
</div>
<footer class="custom-footer mt-5 text-white text-center py-3">
    &copy; <?= date('Y') ?> Created by DibO
    <br> 016-8877623
    <br> Futsal HTP V1.0
</footer>
</body>


</html>
