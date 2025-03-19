/**
 * Plik konfiguracyjny bazy danych
 * Zawiera parametry połączenia z bazą MySQL
 */


<?php
$host = 'localhost';
$dbname = 'ksiegarnia_db';
$username = 'root';
$password = 'root';
$port = '8889'; // dla MAMP

try {
    $pdo = new PDO(
        "mysql:host=$host;port=$port;dbname=$dbname",
        $username,
        $password
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Błąd połączenia z bazą danych: " . $e->getMessage());
}
?>
