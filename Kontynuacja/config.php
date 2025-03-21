<?php
$host = 'localhost';
$dbname = 'ksiegarnia_db';
$username_db = 'root';  
$password_db = 'root';  
$port = '8889'; 

try {
    $pdo = new PDO(
        "mysql:host=$host;port=$port;dbname=$dbname",
        $username_db,  
        $password_db   
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Błąd połączenia z bazą danych: " . $e->getMessage());
}
?>
