<?php
include 'dbconnected.php';

$alert = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fDate   = $_POST['arDate'];
    $fType   = $_POST['arType'];
    $fAmount = $_POST['arAmount'];
    $fDesc   = $_POST['arDesc'];

    $sql = "INSERT INTO transaksi (fDate, fType, fAmount, fDesc)
            VALUES ('$fDate', '$fType', '$fAmount', '$fDesc')";

    if ($conn->query($sql) === TRUE) {
        $alert = "success";
    } else {
        $alert = "error";
        $errorMessage = $conn->error;
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Tambah Rekod</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            background-color: #f8f9fa;
        }
        .custom-footer {
            background-color: #003366;
            border-top: 4px solid #ff6600;
            color: white;
            border-radius: 8px 8px 0 0;
        }
    </style>
</head>
<body>

<!-- Header -->
<div class="bg-dark text-white py-2">
    <div class="container d-flex justify-content-between align-items-center">
        <img src="images/logo.jpeg" alt="Heitech Padu Futsal Logo" style="height: 100px;">
        <h1 class="m-0">Heitech Padu Futsal</h1>
    </div>
</div>

<!-- Main Form Card -->
<div class="container py-5">
    <div class="card shadow">
        <div class="card-body">
            <h2 class="card-title text-center mb-4">+ Tambah Rekod Kewangan</h2>
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="arDate" class="form-label">📅 Tarikh</label>
                    <input type="date" class="form-control" name="arDate" id="arDate" required>
                </div>

                <div class="mb-3">
                    <label for="arType" class="form-label">🔄 Jenis Transaksi</label>
                    <select class="form-select" name="arType" id="arType" required>
                        <option value="masuk">Masuk (Simpanan)</option>
                        <option value="keluar">Keluar (Pengeluaran)</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="arAmount" class="form-label">💵 Amaun (RM)</label>
                    <input type="number" class="form-control" name="arAmount" step="0.01" id="arAmount" required>
                </div>

                <div class="mb-3">
                    <label for="arDesc" class="form-label">📝 Keterangan</label>
                    <input type="text" class="form-control" name="arDesc" id="arDesc" placeholder="Contoh: Tempahan gelanggang">
                </div>

                <div class="d-flex justify-content-between">
                    <a href="index.php" class="btn btn-secondary">← Kembali</a>
                    <button type="submit" class="btn btn-primary">💾 Simpan Rekod</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- SweetAlert Logic -->
<?php if ($alert == "success"): ?>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berjaya!',
        text: 'Rekod simpanan telah ditambah.',
        confirmButtonText: 'OK'
    }).then(() => {
        window.location.href = 'index.php';
    });
</script>
<?php elseif ($alert == "error"): ?>
<script>
    Swal.fire({
        icon: 'error',
        title: 'Ralat!',
        text: <?= json_encode($errorMessage) ?>,
        confirmButtonText: 'OK'
    });
</script>
<?php endif; ?>

<!-- Footer -->
<footer class="custom-footer mt-5 text-white text-center py-3">
    &copy; <?= date('Y') ?> Created by DibO
    <br> 016-8877623
    <br> Futsal HTP V1.0
</footer>

</body>
</html>
