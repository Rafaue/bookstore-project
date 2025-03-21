<?php
session_start();
require_once 'config.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        // Używamy już istniejącego połączenia z config.php
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            header("Location: skup.php");
            exit;
        } else {
            $error = "Nieprawidłowy login lub hasło";
        }
    } catch(PDOException $e) {
        $error = "Błąd połączenia z bazą danych: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie - Księgarnia XYZ</title>
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
        <h2>Logowanie</h2>
        
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="post" class="frosted-glass-form">
            <div class="form-group">
                <label for="username">Login:</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="password">Hasło:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <input type="submit" name="login" value="Zaloguj się">
            </div>

            <p>Nie masz jeszcze konta? <a href="register.php">Zarejestruj się</a></p>
        </form>
    </div>
</body>
</html>
