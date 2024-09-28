<?php
// Veritabanı bağlantısını dahil et
include 'config.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Formdan gelen verileri al
    $isim = $_POST['isim'];
    $barkod = $_POST['barkod'];
    $fiyat = $_POST['fiyat'];
    $stok = $_POST['stok'];

    // Boş alan var mı kontrol et
    if (!empty($isim) && !empty($barkod) && !empty($fiyat) && !empty($stok)) {
        // Barkod veritabanında var mı kontrol et
        $sql_check = "SELECT COUNT(*) FROM urunler WHERE barkod = :barkod";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bindParam(':barkod', $barkod);
        $stmt_check->execute();
        $barkod_exists = $stmt_check->fetchColumn();

        if ($barkod_exists > 0) {
            // Barkod zaten varsa hata mesajı ver
            $message = "Ürün daha önce eklenmiş.";
        } else {
            // Barkod yeni ise ürünü ekle
            $sql = "INSERT INTO urunler (isim, barkod, fiyat, stok) VALUES (:isim, :barkod, :fiyat, :stok)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':isim', $isim);
            $stmt->bindParam(':barkod', $barkod);
            $stmt->bindParam(':fiyat', $fiyat);
            $stmt->bindParam(':stok', $stok);

            // Sorguyu çalıştır
            if ($stmt->execute()) {
                $message = "Ürün başarıyla eklendi!";
            } else {
                $message = "Ürün eklenirken bir hata oluştu.";
            }
        }
    } else {
        $message = "Lütfen tüm alanları doldurun.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ürün Ekle</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            background-image: url('images/fiyat_sorgula.jpg');

            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-image: url('images/urun_ekle.jpg');

            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        label, input {
            margin: 10px 0;
            font-size: 16px;
        }
        input[type="text"], input[type="number"] {
            padding: 10px;
            width: 100%;
            max-width: 300px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }

        /* Başarı veya hata mesajını sol üst köşeye yerleştirmek için stil */
        .message {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: #DFF2BF;
            color: #4F8A10;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.1);
        }

        .message.error {
            background-color: #FFBABA;
            color: #D8000C;
        }
    </style>
</head>
<body>

<?php if ($message): ?>
    <div class="message <?php echo ($message == 'Ürün başarıyla eklendi!') ? '' : 'error'; ?>">
        <?php echo $message; ?>
    </div>
<?php endif; ?>

<div class="container">
    <h2>Ürün Ekle</h2>
    <form action="urun_ekle.php" method="POST">
        <label>Ürün Adı:</label>
        <input type="text" name="isim" required>
        
        <label>Barkod:</label>
        <input type="text" name="barkod" required>
        
        <label>Fiyat:</label>
        <input type="number" step="0.01" name="fiyat" required>

        <label>Stok:</label>
        <input type="number" name="stok" required>
        
        <input type="submit" value="Ürün Ekle">
<div>
<a href="ana_sayfa.php" class="button">Ana Sayfa</a>

</div>

    </form>
</div>

</body>
</html>
