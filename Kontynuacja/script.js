// Inicjalizacja pustego koszyka lub wczytanie z localStorage
let cart = JSON.parse(localStorage.getItem('cart')) || [];

// Funkcja do ładowania koszyka z localStorage (jeśli istnieje)
function loadCart() {
    const storedCart = localStorage.getItem('cart');
    if (storedCart) {
        cart = JSON.parse(storedCart);
    }
}

// Funkcja do zapisywania koszyka w localStorage
function saveCart() {
    localStorage.setItem('cart', JSON.stringify(cart));
}

// Funkcja do dodawania książki do koszyka
function addToCart(book, price) {
    cart.push({ book: book, price: parseFloat(price) });
    saveCart(); // Zapisujemy koszyk do localStorage
    alert(`Dodano "${book}" do koszyka.`);
}

// Funkcja do aktualizacji koszyka na stronie koszyka
function updateCart() {
    let cartItems = $('#cart-items');
    cartItems.empty(); // Opróżniamy poprzednie pozycje

    let totalPrice = 0;
    cart.forEach((item, index) => {
        cartItems.append(`
            <div>
                <span>${item.book}</span>
                <span>${item.price.toFixed(2)} zł</span>
                <button class="remove-button" data-index="${index}">Usuń</button>
            </div>
        `);
        totalPrice += item.price;
    });

    $('#total-price').text(totalPrice.toFixed(2) + ' zł');
}

// Funkcja do usuwania książek z koszyka
function removeFromCart(index) {
    cart.splice(index, 1); // Usunięcie wybranej książki
    updateCart(); // Aktualizacja koszyka po usunięciu
  updateCartCount(); // Aktualizujemy licznik książek w koszyku
    saveCart(); // Zapisz koszyk po zmianach
}

$(document).ready(function() {
    // Ładujemy koszyk z localStorage przy starcie strony
    loadCart();

    // Obsługa kliknięcia na przycisk "Kup teraz"
    $('.buy-button').on('click', function() {
        let book = $(this).data('book');
        let price = $(this).data('price');
        addToCart(book, price); // Dodajemy książkę do koszyka po kliknięciu
    });

    // Sprawdzenie, czy jesteśmy na stronie koszyka i aktualizacja koszyka
    if (window.location.pathname.includes('cart.html')) {
        updateCart(); // Aktualizacja koszyka po otwarciu strony koszyka
    }

    // Obsługa usuwania książek z koszyka
    $(document).on('click', '.remove-button', function() {
        let index = $(this).data('index');
        removeFromCart(index); // Usunięcie książki z koszyka
    });

    // Obsługa przycisku "Przejdź do płatności"
    $('#checkout-button').on('click', function() {
        if (cart.length === 0) {
            alert('Twój koszyk jest pusty.');
        } else {
            // Przekierowanie do strony podsumowania zamówienia (checkout.html)
            window.location.href = 'checkout.html';
        }
    });
});
// AJAX Zaciągający api

$(document).ready(function(){
    $.ajax({
        url:'https://www.googleapis.com/books/v1/volumes?q=harry+potter&filter=paid-ebooks',
        type:'GET',
        dataType:'json',
        success:function(data){
            var html='';
            data.items.forEach(element => {
                html += '<div class="book-item">';
                html += '<img src="'+(element.volumeInfo.imageLinks!=undefined?element.volumeInfo.imageLinks.thumbnail:"images/ksiazka1.jpg")+'" alt="Książka 1">';
                html += ' <p><strong>'+element.volumeInfo.title+'</strong></p>';
                html += '  <button class="buy-button" data-book="'+element.volumeInfo.title+'" data-price="'+element.saleInfo.retailPrice.amount+'">Kup teraz</button>';
                html += ' </div>';
            });
                $('.books-container-cos').html(html)
        }
    })
})


//skrypt do powiekjszania w jq



$(document).ready(function() {
        if (window.location.pathname.includes("Ksiegarnia.html")) {

        // Efekt najechania na książki
        $(".book-item").hover(
            function() {
                // Przy najechaniu zmieniamy wygląd
                $(this).find("img").css("transform", "scale(1.1)");  // Powiększenie zdjęcia
                $(this).find("button").fadeIn(200);  // Pokazujemy przycisk
            },
            function() {
                // Po zdjęciu kursora, przywracamy oryginalny wygląd
                $(this).find("img").css("transform", "scale(1)");  // Przywracamy rozmiar
                $(this).find("button").fadeOut(200);  // Ukrywamy przycisk
            }
        );
    }
});



// Funkcja do wyświetlania liczby książek w koszyku
function updateCartCount() {
    const cartCount = cart.length; // Liczymy liczbę elementów w koszyku
    // Aktualizujemy element w DOM, który wyświetla liczbę książek w koszyku
    document.getElementById("cart-count").textContent = cartCount;
}

// Zaktualizuj liczbę książek po każdej zmianie w koszyku
$(document).ready(function() {
    // Po dodaniu książki do koszyka
    $('.buy-button').on('click', function() {
        updateCartCount(); // Aktualizacja liczby książek po dodaniu do koszyka
    });
    
    // Sprawdzenie koszyka po załadowaniu strony
    updateCartCount(); // Na starcie strony, wyświetlamy aktualną liczbę książek w koszyku
});



// Funkcja do zmiany ilości książki w koszyku
function changeQuantity(index, action) {
    if (action === "increase") {
        cart[index].quantity += 1; // Zwiększamy ilość książki
    } else if (action === "decrease" && cart[index].quantity > 1) {
        cart[index].quantity -= 1; // Zmniejszamy ilość książki, nie pozwalamy na wartość poniżej 1
    }
    saveCart(); // Zapisujemy koszyk po zmianie ilości
    updateCart(); // Aktualizujemy koszyk na stronie
}

// Przykład zmiany ilości książki (dodanie przycisków + i -)
$(document).ready(function() {
    $(document).on('click', '.increase-button', function() {
        let index = $(this).data('index');
        changeQuantity(index, 'increase');
    });

    $(document).on('click', '.decrease-button', function() {
        let index = $(this).data('index');
        changeQuantity(index, 'decrease');
    });
});



$(document).ready(function() {
    // Animacja dodawania książki do koszyka
    $('.buy-button').on('click', function() {
        let bookTitle = $(this).data('book');
        let price = $(this).data('price');

        // tymczasowy element, który będzie animowany
        let tempBook = $(this).closest('.book-item').clone();
        
        // Ustawiamy pozycję startową animacji
        tempBook.css({
            position: 'absolute',
            top: $(this).offset().top,
            left: $(this).offset().left
        });

        // Dodajemy tymczasowy element na stronę 
        $('body').append(tempBook);
        
        // Animacja przesunięcia książki do koszyka
        tempBook.animate({
            top: $('#cart-count').offset().top,
            left: $('#cart-count').offset().left,
            width: 0,
            height: 0
        }, 500, function() {
            $(this).remove(); // Usuwamy tymczasowy element po animacji
            updateCartCount(); // Aktualizujemy licznik książek w koszyku
        });
    });
});


// Nie uzywane:

//$(document).ready(function() {
    // 1. Przy kliknięciu przycisku "Pokaż koszyk"
   // $('#toggle-cart').on('click', function() {
    //    $('#cart-modal').fadeIn(); // Pokazujemy modal z animacją
   // });

    // 2. Przy kliknięciu przycisku zamknięcia (X)
   // $('#close-modal').on('click', function() {
      //  $('#cart-modal').fadeOut(); // Ukrywamy modal z animacją
    //});

    // 3. Ukrycie modalnego okienka, gdy klikniesz gdziekolwiek poza modalem
   // $(window).on('click', function(event) {
   //     if ($(event.target).is('#cart-modal')) {
   //         $('#cart-modal').fadeOut(); // Ukryj modal jeśli klikniesz poza jego obszarem
   //     }
   // });

    // 4. Zaktualizowanie zawartości koszyka w modalu (przykład dynamicznego dodawania)
    // Można tu dodać kod, który będzie aktualizował zawartość koszyka po jego załadowaniu
    // (np. z localStorage lub z tablicy).
  //  function updateCartContent() {
   //     let cart = JSON.parse(localStorage.getItem('cart')) || [];
    //    let cartItemsHtml = '';
    //    let totalPrice = 0;

    //    cart.forEach(item => {
    //        cartItemsHtml += `<p>${item.book} - ${item.price.toFixed(2)} zł</p>`;
    //        totalPrice += item.price;
      //  });

     //   $('#cart-items').html(cartItemsHtml);
    //    $('#total-price').text(totalPrice.toFixed(2) + ' zł');
   // }

    // Zaktualizuj zawartość koszyka po załadowaniu strony
  // updateCartContent();
//});
