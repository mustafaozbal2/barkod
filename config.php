<?php
$host = 'localhost';  // Sunucu adı
$dbname = 'market';   // Veritabanı adı
$username = 'root';   // MySQL kullanıcı adı
$password = 'Qwe123?.';       // MySQL şifresi (Varsa girin)

try {
    // PDO ile veritabanı bağlantısı oluşturma
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Veritabanı bağlantısı başarısız: " . $e->getMessage();
}
?>

