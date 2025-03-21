// cart.js

let cart = [];

// Funkcja dodająca przedmiot do koszyka
function addToCart(button) {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    const item = {
        name: button.getAttribute("data-book"), 
        price: button.getAttribute("data-price")
    };

    cart.push(item);
    localStorage.setItem("cart", JSON.stringify(cart));
    alert(`Dodano do koszyka: ${item.name}`);
}
//
function addToCart(button) {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    const item = {
        name: button.getAttribute("data-book"),
        price: button.getAttribute("data-price")
    };

    cart.push(item);
    localStorage.setItem("cart", JSON.stringify(cart));
    console.log("Aktualna zawartość koszyka:", cart); // Sprawdź dane zapisane w koszyku
}
//

// Funkcja do aktualizacji koszyka na stronie
function updateCart() {
    let cartItems = $('#cart-items');
    cartItems.empty(); // Opróżnia poprzednie pozycje
    
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
    
    // Dodanie funkcji usuwania
    $('.remove-button').on('click', function() {
        let index = $(this).data('index');
        cart.splice(index, 1);
        updateCart();
    });
}

//Przechowywanie koszyka w localStorage
$(document).ready(function() {
    // Ładowanie koszyka z localStorage przy starcie
    if (localStorage.getItem('cart')) {
        cart = JSON.parse(localStorage.getItem('cart'));
        updateCart();
    }
    
    // Zapisywanie koszyka w localStorage przy zmianie
    function saveCart() {
        localStorage.setItem('cart', JSON.stringify(cart));
    }
    
    // Modyfikacja funkcji addToCart, aby zapisywać koszyk
    window.addToCart = function(book, price) {
        cart.push({ book: book, price: parseFloat(price) });
        updateCart();
        saveCart();
        alert(`Dodano "${book}" do koszyka.`);
    };
    
    // Modyfikacja funkcji usuwania, aby zapisywać koszyk
    $(document).on('click', '.remove-button', function() {
        let index = $(this).data('index');
        cart.splice(index, 1);
        updateCart();
        saveCart();
    });
    
    // Obsługa przycisku 
    $('#checkout-button').on('click', function() {
        if (cart.length === 0) {
            alert('Twój koszyk jest pusty.');
        } else {
            alert('Przejdź do procesu płatności.');
  
        }
    });
});
