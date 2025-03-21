<?php
require_once 'config.php';

// Inicjalizacja zmiennych
$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Pobieranie danych z formularza
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');
    $age = trim($_POST['age'] ?? '');
    $newsletter = isset($_POST['newsletter']) ? 1 : 0;
    $contact_preference = $_POST['contact_preference'] ?? '';

    // Walidacja
    if (empty($name)) {
        $errors[] = "Imię i nazwisko jest wymagane";
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Podaj prawidłowy adres email";
    }

    if (!empty($phone) && !preg_match("/^[0-9]{9}$/", $phone)) {
        $errors[] = "Nieprawidłowy format numeru telefonu";
    }

    if (empty($subject)) {
        $errors[] = "Temat jest wymagany";
    }

    if (empty($message)) {
        $errors[] = "Wiadomość jest wymagana";
    }

    // Obsługa przesyłania pliku
    $file_path = null;
    if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == 0) {
        $allowed = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];
        $filename = $_FILES['attachment']['name'];
        $filetype = pathinfo($filename, PATHINFO_EXTENSION);
        
        if (!in_array(strtolower($filetype), $allowed)) {
            $errors[] = "Niedozwolony typ pliku. Dozwolone: " . implode(', ', $allowed);
        } else {
            $upload_dir = 'uploads/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            $file_path = $upload_dir . time() . '_' . $filename;
            if (!move_uploaded_file($_FILES['attachment']['tmp_name'], $file_path)) {
                $errors[] = "Błąd podczas przesyłania pliku";
            }
        }
    }

    // Jeśli nie ma błędów, zapisz do bazy
    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO contact_forms (name, email, phone, subject, 
                                  message, age, newsletter, contact_preference, file_path) 
                                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            
            $stmt->execute([
                $name, 
                $email, 
                $phone, 
                $subject, 
                $message, 
                $age, 
                $newsletter, 
                $contact_preference,
                $file_path
            ]);
            
            $success = true;
            
        } catch(PDOException $e) {
            $errors[] = "Błąd podczas zapisywania danych: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontakt - Księgarnia XYZ</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .error-message {
            color: #dc3545;
            background-color: #f8d7da;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 4px;
        }
        .success-message {
            color: #28a745;
            background-color: #d4edda;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 4px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-check {
            margin: 10px 0;
        }
        ::placeholder {
            color: #999;
            opacity: 1;
        }
        .contact-form input[type="text"],
        .contact-form input[type="email"],
        .contact-form input[type="tel"],
        .contact-form input[type="number"],
        .contact-form textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .submit-button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .submit-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body id="contact-page">
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

      </nav>
  </header>
    
    <main>
        <section>
            <h2>Formularz kontaktowy</h2>
            
            <?php if (!empty($errors)): ?>
                <?php foreach ($errors as $error): ?>
                    <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="success-message">Formularz został wysłany pomyślnie!</div>
            <?php endif; ?>

            <form id="contact-form" class="contact-form frosted-glass" method="post" action="" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Imię i nazwisko: *</label>
                    <input type="text" id="name" name="name" placeholder="Wprowadź imię i nazwisko" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Adres e-mail: *</label>
                    <input type="email" id="email" name="email" placeholder="przykład@email.com" required>
                </div>
                
                <div class="form-group">
                    <label for="phone">Telefon:</label>
                    <input type="tel" id="phone" name="phone" placeholder="123456789">
                </div>

                <div class="form-group">
                    <label for="age">Wiek:</label>
                    <input type="number" id="age" name="age" placeholder="Wprowadź wiek" min="18" max="100">
                </div>

                <div class="form-group">
                    <label for="subject">Temat: *</label>
                    <input type="text" id="subject" name="subject" placeholder="Wprowadź temat wiadomości" required>
                </div>

                <div class="form-group">
                    <label for="message">Wiadomość: *</label>
                    <textarea id="message" name="message" rows="5" placeholder="Wprowadź treść wiadomości" required></textarea>
                </div>

                <div class="form-group">
                    <label>Preferowana forma kontaktu:</label>
                    <div class="form-check">
                        <input type="radio" id="contact_email" name="contact_preference" value="email">
                        <label for="contact_email">Email</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" id="contact_phone" name="contact_preference" value="phone">
                        <label for="contact_phone">Telefon</label>
                    </div>
                </div>

                <div class="form-check">
                    <input type="checkbox" id="newsletter" name="newsletter" value="1">
                    <label for="newsletter">Chcę otrzymywać newsletter</label>
                </div>

                <div class="form-group">
                    <label for="attachment">Załącznik:</label>
                    <input type="file" id="attachment" name="attachment">
                    <small>Dozwolone formaty: PDF, DOC, DOCX, JPG, JPEG, PNG</small>
                </div>
                
                <button type="submit" class="submit-button">Wyślij</button>
            </form>
        </section>

        <section>
            <h2>Nasze dane kontaktowe</h2>
            <p><strong>Adres:</strong> Księgarnia XYZ, ul. Książkowa 1, 00-001 Warszawa</p>
            <p><strong>Telefon:</strong> +48 123 456 789</p>
            <p><strong>E-mail:</strong> kontakt@ksiegarniaxyz.pl</p>
        </section>
    </main>
    
    <footer>
        <p>© 2024 Księgarnia XYZ. Wszelkie prawa zastrzeżone.</p>
    </footer>
</body>
</html>
