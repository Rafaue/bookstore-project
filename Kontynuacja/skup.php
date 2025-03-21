<?php
session_start();

// Sprawdzenie czy użytkownik jest zalogowany
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once 'config.php';

// Połączenie z bazą danych
$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username_db, $password_db);

// Wyświetlenie książek
$ksiazki = $pdo->query("SELECT * FROM ksiazki");

// Wyświetlenie kategorii
$kategorie = $pdo->query("SELECT * FROM kategorie");

// Wyświetlenie zamówień wraz z informacjami o książkach i kategoriach
$zamowienia = $pdo->query("
    SELECT z.*, k.tytul as tytul_ksiazki, kat.nazwa as nazwa_kategorii 
    FROM zamowienia z 
    LEFT JOIN ksiazki k ON z.id_ksiazki = k.id 
    LEFT JOIN kategorie kat ON z.id_kategorii = kat.id
");

// Dodawanie nowej książki
if (isset($_POST['dodaj_ksiazke'])) {
    $tytul = $_POST['tytul'];
    $autor = $_POST['autor'];
    $cena = $_POST['cena'];
    $opis = $_POST['opis'];

    $pdo->query("INSERT INTO ksiazki (tytul, autor, cena, opis) VALUES ('$tytul', '$autor', '$cena', '$opis')");
    header("Location: skup.php");
    exit;
}

// Dodawanie nowej kategorii
if (isset($_POST['dodaj_kategorie'])) {
    $nazwa = $_POST['nazwa'];
    $opis = $_POST['opis'];

    $pdo->query("INSERT INTO kategorie (nazwa, opis) VALUES ('$nazwa', '$opis')");
    header("Location: skup.php");
    exit;
}

// Dodawanie nowego zamówienia
if (isset($_POST['dodaj_zamowienie'])) {
    $id_ksiazki = $_POST['id_ksiazki'];
    $id_kategorii = $_POST['id_kategorii'];
    $data_zamowienia = $_POST['data_zamowienia'];
    $status_zamowienia = $_POST['status_zamowienia'];

    $stmt = $pdo->prepare("SELECT * FROM ksiazki WHERE id = ?");
    $stmt->execute([$id_ksiazki]);
    $ksiazka = $stmt->fetch();

    if ($ksiazka) {
        $pdo->query("INSERT INTO zamowienia (id_ksiazki, id_kategorii, data_zamowienia, status_zamowienia) VALUES ('$id_ksiazki', '$id_kategorii', '$data_zamowienia', '$status_zamowienia')");
        header("Location: skup.php");
        exit;
    } else {
        echo "Książka o tym ID nie istnieje.";
    }
}

// Usuwanie książki
if (isset($_POST['usun_ksiazke'])) {
    $id = $_POST['id'];
    $pdo->query("DELETE FROM ksiazki WHERE id = '$id'");
    header("Location: skup.php");
    exit;
}

// Usuwanie kategorii
if (isset($_POST['usun_kategorie'])) {
    $id = $_POST['id'];
    $pdo->query("DELETE FROM kategorie WHERE id = '$id'");
    header("Location: skup.php");
    exit;
}

// Usuwanie zamówienia
if (isset($_POST['usun_zamowienie'])) {
    $id = $_POST['id'];
    $pdo->query("DELETE FROM zamowienia WHERE id = '$id'");
    header("Location: skup.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skup - Księgarnia XYZ</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <a href="index.php">
            <img src="images/logo.png" alt="Logo Księgarnia XYZ">
        </a>
        <nav>
            <a href="books.html">Książki</a>
            <a href="about.html">O nas</a>
            <a href="contact.php">Kontakt</a>
            <a href="skup.php">Skup</a>
            <a href="cart.html">Koszyk</a>
            <div class="user-section">
                <?php if (isset($_SESSION['user_name'])): ?>
                    <span>Witaj, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                    <a href="logout.php" class="logout-btn">Wyloguj</a>
                <?php else: ?>
                    <a href="login.php">Zaloguj się</a>
                    <span style="margin: 0 5px;">lub</span>
                    <a href="register.php">Zarejestruj się</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>

    <div class="frosted-glass">
        <h1>Skup</h1>
        
        <h2>Książki</h2>
        <ul>
            <?php foreach ($ksiazki as $ksiazka) { ?>
                <li>
                    <h3><?php echo $ksiazka['tytul']; ?></h3>
                    <p>Autor: <?php echo $ksiazka['autor']; ?></p>
                    <p>Cena: <?php echo $ksiazka['cena']; ?></p>
                    <p>Opis: <?php echo $ksiazka['opis']; ?></p>
                    <form action="" method="post">
                        <input type="hidden" name="id" value="<?php echo $ksiazka['id']; ?>">
                        <input type="submit" name="usun_ksiazke" value="Usuń">
                    </form>
                </li>
            <?php } ?>
        </ul>
        
        <h2>Kategorie</h2>
        <ul>
            <?php foreach ($kategorie as $kategoria) { ?>
                <li>
                    <h3><?php echo $kategoria['nazwa']; ?></h3>
                    <p>Opis: <?php echo $kategoria['opis']; ?></p>
                    <form action="" method="post">
                        <input type="hidden" name="id" value="<?php echo $kategoria['id']; ?>">
                        <input type="submit" name="usun_kategorie" value="Usuń">
                    </form>
                </li>
            <?php } ?>
        </ul>
        
        <h2>Zamówienia</h2>
        <ul>
            <?php foreach ($zamowienia as $zamowienie) { ?>
                <li>
                    <h3>Książka: <?php echo $zamowienie['tytul_ksiazki']; ?></h3>
                    <p>Kategoria: <?php echo $zamowienie['nazwa_kategorii']; ?></p>
                    <p>Data zamówienia: <?php echo $zamowienie['data_zamowienia']; ?></p>
                    <p>Status zamówienia: <?php echo $zamowienie['status_zamowienia']; ?></p>
                    <form action="" method="post">
                        <input type="hidden" name="id" value="<?php echo $zamowienie['id']; ?>">
                        <input type="submit" name="usun_zamowienie" value="Usuń">
                    </form>
                </li>
            <?php } ?>
        </ul>
        
        <h2>Dodaj nową książkę</h2>
        <form action="" method="post" class="frosted-glass-form">
            <label for="tytul">Tytuł:</label>
            <input type="text" id="tytul" name="tytul" required><br><br>
            <label for="autor">Autor:</label>
            <input type="text" id="autor" name="autor" required><br><br>
            <label for="cena">Cena:</label>
            <input type="number" id="cena" name="cena" step="0.01" required><br><br>
            <label for="opis">Opis:</label>
            <textarea id="opis" name="opis" required></textarea><br><br>
            <input type="submit" name="dodaj_ksiazke" value="Dodaj">
        </form>
        
        <h2>Nie ma twojej kategorii? Dodaj nową kategorię!</h2>
        <form action="" method="post" class="frosted-glass-form">
            <label for="nazwa">Nazwa:</label>
            <input type="text" id="nazwa" name="nazwa" required><br><br>
            <label for="opis">Opis:</label>
            <textarea id="opis" name="opis" required></textarea><br><br>
            <input type="submit" name="dodaj_kategorie" value="Dodaj">
        </form>
        
        <h2>Dodaj nowe zamówienie</h2>
<form action="" method="post" class="frosted-glass-form">
    <label for="id_ksiazki">Wybierz książkę:</label>
    <select id="id_ksiazki" name="id_ksiazki" required>
        <option value="">-- Wybierz książkę --</option>
        <?php 
        $ksiazki_lista = $pdo->query("SELECT * FROM ksiazki")->fetchAll();
        foreach ($ksiazki_lista as $ksiazka) { 
        ?>
            <option value="<?php echo $ksiazka['id']; ?>">
                <?php echo htmlspecialchars($ksiazka['tytul']) . ' - ' . 
                      htmlspecialchars($ksiazka['autor']) . ' (' . 
                      number_format($ksiazka['cena'], 2) . ' zł)'; ?>
            </option>
        <?php } ?>
    </select><br><br>

    <label for="id_kategorii">Wybierz kategorię:</label>
    <select id="id_kategorii" name="id_kategorii" required>
        <option value="">-- Wybierz kategorię --</option>
        <?php 
        $kategorie_lista = $pdo->query("SELECT * FROM kategorie")->fetchAll();
        foreach ($kategorie_lista as $kategoria) { 
        ?>
            <option value="<?php echo $kategoria['id']; ?>">
                <?php echo htmlspecialchars($kategoria['nazwa']); ?>
            </option>
        <?php } ?>
    </select><br><br>

    <label for="data_zamowienia">Data zamówienia:</label>
    <input type="date" id="data_zamowienia" name="data_zamowienia" 
           value="<?php echo date('Y-m-d'); ?>" required><br><br>

    <label for="status_zamowienia">Status zamówienia:</label>
    <select id="status_zamowienia" name="status_zamowienia" required>
        <option value="">-- Wybierz status --</option>
        <option value="nowe">Nowe</option>
        <option value="w realizacji">W realizacji</option>
        <option value="zrealizowane">Zrealizowane</option>
        <option value="anulowane">Anulowane</option>
    </select><br><br>

    <input type="submit" name="dodaj_zamowienie" value="Dodaj zamówienie">
</form>
    </div>
</body>
</html>
