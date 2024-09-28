<?php
// Veritabanı bağlantısını dahil et
include 'config.php';

$sonuc = '';
$toplam_fiyat = 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Formdan gelen barkodları al ve virgülle ayırarak diziye çevir
    $barkodlar = explode(',', $_POST['barkodlar']);

    // Her barkod için fiyatı sorgulama ve toplama işlemi
    foreach ($barkodlar as $barkod) {
        $barkod = trim($barkod); // Başında ve sonunda boşluk varsa sil
        $sql = "SELECT isim, fiyat FROM urunler WHERE barkod = :barkod";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':barkod', $barkod);
        $stmt->execute();

        $urun = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($urun) {
            // Ürün bulunduysa ismi ve fiyatı göster ve fiyatı toplamına ekle
            $sonuc .= "Ürün İsmi: " . $urun['isim'] . " - Fiyat: " . $urun['fiyat'] . " TL<br>";
            $toplam_fiyat += $urun['fiyat'];
        } else {
            // Ürün bulunamazsa kullanıcıya bilgi ver
            $sonuc .= "Barkod: $barkod için ürün bulunamadı!<br>";
        }
    }

    // Toplam fiyatı göster
    $sonuc .= "<br><strong>Toplam Fiyat: " . $toplam_fiyat . " TL</strong>";
}
?>

<!DOCTYPE html>
<html>
<head>
    
    <title>Fiyat Sorgulama</title>
</head>

<body>
    <h2>Ürün Fiyatlarını Sorgula</h2>
    <form method="POST" action="fiyat_sorgula.php">
       
        <label>Barkod:</label>
        <input type="text" name="barkodlar" required><br><br>
        
        <input type="submit" value="Sorgula">
    </form>

    <h3><?php echo $sonuc; ?></h3> <!-- Sonuç burada gösterilecek -->
</body>
</html>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fiyat Sorgula</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function showPrice(productName, price) {
            const resultDiv = document.getElementById('result');
            resultDiv.innerHTML = `${productName} fiyat: <span style="color: green;">${price} fiyat</span>`;
        }
    </script>
</head>
<style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding-top: 50px;
            margin: 0;
            background-image: url('images/fiyat_sorgula.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: white;
        }
        .container {
            background-image: url('images/market_arka_plan.jpg');

            display: inline-block;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.5); /* Opaklık ve arka planın görünürlüğü için */
            border-radius: 10px;
        }
        .button {
            display: block;
            width: 200px;
            padding: 10px;
            margin: 10px auto;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            font-size: 18px;
            border-radius: 5px;
        }
        .button:hover {
            background-color: #45a049;
        }
    </style>
<body>
    <div class="container">
        <h1>Fiyat Sorgulama</h1>
        <div class="product-boxes">
            <?php
            // Veritabanı bağlantısı
            $conn = new mysqli('localhost', 'root', 'Qwe123?.', 'market');

            // Bağlantıyı kontrol et
            if ($conn->connect_error) {
                die("Bağlantı hatası: " . $conn->connect_error);
            }

            // Silme işlemi
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
                $deleteName = $_POST['delete'];
                $deleteSql = "DELETE FROM urunler WHERE isim = ?";
                $stmt = $conn->prepare($deleteSql);
                $stmt->bind_param("s", $deleteName);
                $stmt->execute();
                $stmt->close();
            }

            // İsimleri çekme sorgusu
            $sql = "SELECT isim, fiyat FROM urunler";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Her bir ismi kutular içinde göster
                while($row = $result->fetch_assoc()) {
                    // Tek renk (yeşil) arka plan
                    $backgroundColor = '';
                    echo '<div class="product-box" style="background-color: ' . $backgroundColor . '; color: green; font-size: 1.5em; display: flex; justify-content: space-between; align-items: center; height: 100px; padding: 0 20px;">';
                    echo htmlspecialchars($row['isim']);
                    echo '<form style="display:inline;" method="POST">';
                    echo '<button type="submit" name="delete" value="' . htmlspecialchars($row['isim']) . '" style="background-color: red; color: white; border: none; padding: 10px; cursor: pointer; border-radius: 5px;">Sil</button>';
                    echo '</form>';
                    echo '</div>';
                }
            } else {
                echo "İsim bulunamadı.";
            }

            // Bağlantıyı kapat
            $conn->close();
            ?>
        </div>
        <div id="result" class="result" style="position: absolute; top: 20px; right: 20px;"></div>
        <a href="ana_sayfa.php" class="button">Ana Sayfa</a>

    </div>
</body>
</html>
