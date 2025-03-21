// checkout.js

// Inicjalizacja koszyka z localStorage
let cart = JSON.parse(localStorage.getItem('cart')) || [];

// Funkcja do załadowania zamówienia na stronie podsumowania
function loadOrder() {
    let orderItems = $('#order-items');
    orderItems.empty(); // Opróżnia poprzednie pozycje
    
    let totalPrice = 0;
    cart.forEach(item => {
		console.log(item)
        orderItems.append(`
            <div>
                <span>${item.book}</span>
                <span>${item.price.toFixed(2)} zł</span>
            </div>
        `);
        totalPrice += item.price;
    });
    
    $('#order-total-price').text(totalPrice.toFixed(2) + ' zł');
}

// Obsługa formularza zamówienia
$('#checkout-form').on('submit', function(event) {
    event.preventDefault(); // Zatrzymaj domyślne przesłanie formularza
    
    // Zbierz dane z formularza
    let customerData = {
        name: $('#name').val(),
        address: $('#address').val(),
        email: $('#email').val(),
        payment: $('#payment').val(),
        cart: cart, // Przekażemy także pozycje koszyka
        totalPrice: $('#order-total-price').text()
    };
    
    // Wyślij dane zamówienia TO TAk NA PRZYSZLOSC
    console.log("Zamówienie złożone: ", customerData);
    
    
    alert('Zamówienie zostało złożone!');
    localStorage.removeItem('cart'); // Opróżnij koszyk po złożeniu zamówienia
    window.location.href = 'confirmation.html'; // Przekieruj na stronę potwierdzenia
});

// Załaduj dane zamówienia po otwarciu strony
$(document).ready(function() {
    loadOrder();
});

//

// Funkcja wyświetlająca zawartość koszyka
function displayCartItems() {
    const cart = JSON.parse(localStorage.getItem("cart")) || [];
    const orderSummary = document.getElementById("order-summary");

    // czy koszyk jest pusty
    if (cart.length === 0) {
        orderSummary.innerHTML = "<p>Twój koszyk jest pusty.</p>";
        return;
    }

    // Tworzenie listy zamówień
    let cartItemsHTML = "<ul>";
    let totalPrice = 0;

    cart.forEach(item => {
        cartItemsHTML += `<li>${item.book} - ${item.price.toFixed(2)} zł</li>`;
        totalPrice += item.price;
    });

    cartItemsHTML += `</ul><p>Łączna cena: ${totalPrice.toFixed(2)} zł</p>`;
    orderSummary.innerHTML = cartItemsHTML;
}

// Wywołaj funkcję po załadowaniu strony
document.addEventListener("DOMContentLoaded", displayCartItems);
