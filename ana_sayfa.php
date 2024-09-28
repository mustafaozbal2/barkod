<!DOCTYPE html>
<html>
<head>
    <title>Market Uygulaması Ana Sayfa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding-top: 50px;
            margin: 0;
            background-image: url('images/market_arka_plan.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: white;
        }
        .container {
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
</head>
<body>
    <h1>Market Yönetim Sistemi</h1>
    <div class="container">
        <!-- Ürün Ekleme Butonu -->
        <a href="urun_ekle.php" class="button">Ürün Ekle</a>
        
        <!-- Fiyat Sorgulama Butonu -->
        <a href="fiyat_sorgula.php" class="button">Fiyat Sorgula</a>
    </div>
</body>
</html>