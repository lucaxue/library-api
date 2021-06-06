# A simple 📚 library API

A simple library RESTful API, made with Laravel for a MySQL database.

<br>

## 📄 API Specs

### Route: `/api/books`

#### GET

-   Get all books
    -   `api/books`
-   Get book by id
    -   `api/books/{id}`
-   Search books by title or author
    -   `api/books?search=foo`
-   Paginate books (15 books per page)
    -   `api/books?page=3`

#### POST

-   Post new book
    -   `api/books`

#### PUT

-   Update book
    -   `api/books/{id}`

#### DELETE

-   Delete book
    -   `api/books/{id}`

<br>

## To Do:

-   [ ] Unit Test Controller

<br>

## ⚙️ Setting Up

-   Install dependencies
    ```
    composer install
    ```
-   Make a new MySQL database, and name it library
-   Copy and add your connection details to the `.env` file
    ```
    cp .env.example .env
    ```
-   Generate your new app key
    ```
    php artisan key:generate
    ```
-   Migrate the tables to your database
    ```
    php artisan migrate
    ```
-   Add dummy data to your database
    ```
    php artisan tinker
    ```
    ```
    Book::factory()->count(100)->create()
    ```
-   Run the app on your local port
    ```
    php artisan serve
    ```
