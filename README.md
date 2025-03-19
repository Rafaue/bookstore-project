# Księgarnia Internetowa XYZ

https://rafaue.github.io/bookstore-project/books.html

## Opis projektu
Projekt "Księgarnia Internetowa XYZ" to moja pierwsza strona internetowa napisana od podstaw, stworzona w ramach przedmiotu Technologie Internetowe na studiach informatycznych. Projekt został zrealizowany w dwóch etapach, zgodnie z wymaganiami przedmiotu, i obejmuje zarówno część frontendową, jak i backendową.

## Struktura projektu
Repozytorium zawiera:
- **Główny folder** - zawiera pliki pierwszego etapu projektu (strona statyczna z elementami JavaScript)
- **Folder `/kontynuacja`** - zawiera pliki drugiego etapu projektu (backend w PHP i baza danych MySQL)

## Etap I: Frontend (HTML, CSS, JavaScript, jQuery)
Pierwszy etap projektu obejmuje stworzenie statycznej strony internetowej księgarni z wykorzystaniem technologii frontendowych.

### Funkcjonalności
- Strona główna z prezentacją nowości wydawniczych
- Podstrona "O nas" z informacjami o księgarni
- Katalog książek z podziałem na kategorie
- Koszyk zakupowy (funkcjonalność JavaScript)
- Formularz realizacji zamówienia
- Strona potwierdzenia zamówienia
- Strona kontaktowa

### Technologie
- HTML5
- CSS3
- JavaScript
- jQuery

## Etap II: Backend (PHP, MySQL)
Drugi etap projektu rozszerza stronę o funkcjonalności backendowe, umożliwiające rzeczywistą obsługę użytkowników i zamówień.

### Funkcjonalności
- Baza danych MySQL z trzema tabelami powiązanymi relacjami (users, books, orders)
- System rejestracji i logowania użytkowników
- Dynamiczne generowanie katalogu książek z bazy danych
- Pełna funkcjonalność koszyka zakupowego z zapisem do bazy danych
- Przetwarzanie formularzy z walidacją
- Zapisywanie zamówień w bazie danych

### Technologie
- PHP
- MySQL
- JavaScript (AJAX)


## Struktura bazy danych
- **Tabela `users`**: Przechowuje dane użytkowników (id, username, password, email, address)
- **Tabela `books`**: Zawiera informacje o książkach (id, title, author, price, category, description, image_url, stock)
- **Tabela `orders`**: Przechowuje zamówienia użytkowników (id, user_id, order_date, total_price, status)

## Autor
Rafaue

---

# XYZ Online Bookstore

## Project Description
The "XYZ Online Bookstore" project is a website created as part of the Internet Technologies course in computer science studies. The project was implemented in two stages, according to the course requirements, and includes both frontend and backend components.

## Project Structure
The repository contains:
- **Main folder** - contains files from the first stage of the project (static website with JavaScript elements)
- **`/kontynuacja` folder** - contains files from the second stage of the project (PHP backend and MySQL database)

## Stage I: Frontend (HTML, CSS, JavaScript, jQuery)
The first stage of the project involves creating a static bookstore website using frontend technologies.

### Features
- Homepage with new releases
- "About Us" page with bookstore information
- Book catalog with category divisions
- Shopping cart (JavaScript functionality)
- Order checkout form
- Order confirmation page
- Contact page

### Technologies
- HTML5
- CSS3
- JavaScript
- jQuery

## Stage II: Backend (PHP, MySQL)
The second stage of the project extends the website with backend functionalities, enabling actual user and order management.

### Features
- MySQL database with three tables linked by relationships (users, books, orders)
- User registration and login system
- Dynamic generation of book catalog from database
- Full shopping cart functionality with database storage
- Form processing with validation
- Order storage in database

### Technologies
- PHP
- MySQL
- JavaScript (AJAX)

## Database Structure
- **`users` table**: Stores user data (id, username, password, email, address)
- **`books` table**: Contains information about books (id, title, author, price, category, description, image_url, stock)
- **`orders` table**: Stores user orders (id, user_id, order_date, total_price, status)

## Author
Rafaue
