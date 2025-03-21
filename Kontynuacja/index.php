<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Księgarnia Online</title>
    <script
      src="https://code.jquery.com/jquery-3.7.1.min.js"
      integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
      crossorigin="anonymous"></script>
    <script src="script.js"></script> 
    <link rel="stylesheet" href="styles.css">
</head>
<body class="ksiegarnia-page">

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
<div id="cart-count-container">
  <span id="cart-count">0</span>
</div>
      </nav>
  </header>
    
    <main>
        <!-- Baner promocyjny -->
        <section class="promo-banner">
            <h2>Wielka Wyprzedaż Książek!</h2>
            <div class="slide-in">
   <p>Do końca miesiąca oferujemy aż do 50% zniżki na wybrane książki! Sprawdź naszą ofertę i znajdź coś dla siebie!</p>
</div>
        </section>

        <!-- Polecane książki -->
        <section class="best-books-section">
            <h2>Już w przyszłym miesiącu!</h2>
            <div class="books-container-cos books-container">
                
            </div>
        </section>
        <!-- Nowości -->
        <section>
            <h2>Nowości w naszej księgarni</h2>
            <div class="books-container">
                <div class="book-item">
                    <img src="images/ksiazka7.jpg" alt="Książka 7">
                    <p><strong>Miłość i inne kłopoty</strong> - Monika Sznajderman Romans, Dramat</p>
                    <button class="buy-button" data-book="Miłość i inne kłopoty" data-price="27.99">Kup teraz</button>
                </div>
                <div class="book-item">
                    <img src="images/ksiazka8.jpg" alt="Książka 8">
                    <p><strong>Kod Biblii</strong> - Dan Brown Thriller, Historyczny</p>
                    <button class="buy-button" data-book="Kod Biblii" data-price="32.99">Kup teraz</button>
                </div>
            </div>
        </section>

        <!-- Formularz newslettera -->
        <section class="newsletter">
            <h3>Chcesz być na bieżąco?</h3>
            <p>Subskrybuj nasz newsletter i otrzymuj informacje o nowościach, promocjach oraz wydarzeniach w naszej księgarni.</p>
            <input type="email" placeholder="Twój e-mail">
            <button>Zapisz się</button>
        </section>
    </main>

    <footer>
        <p>© 2024 Księgarnia XYZ. Wszelkie prawa zastrzeżone.</p>
    </footer>
    
    <script src="script.js"></script> 
</body>
</html>
