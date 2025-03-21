<?php
session_start();
require_once 'config.php';

if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO users (name, username, password) VALUES (?, ?, ?)");
        $stmt->execute([$name, $username, $password]);
        
        header("Location: login.php?registered=true");
        exit;
    } catch(PDOException $e) {
        if ($e->getCode() == 23000) {
            $error = "Ten login jest już zajęty";
        } else {
            $error = "Błąd podczas rejestracji: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rejestracja - Księgarnia XYZ</title>
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
                <a href="login.php">Zaloguj się</a>
                <span style="margin: 0 5px;">lub</span>
                <a href="register.php">Zarejestruj się</a>
            </div>
        </nav>
    </header>

    <div class="frosted-glass">
        <h2>Rejestracja</h2>
        
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="post" class="frosted-glass-form">
            <div class="form-group">
                <label for="name">Imię:</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="username">Login:</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="password">Hasło:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <input type="submit" name="register" value="Zarejestruj się">
            </div>

            <p>Masz już konto? <a href="login.php">Zaloguj się</a></p>
        </form>
    </div>
</body>
</html>
