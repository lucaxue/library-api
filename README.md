# A simple 📚 library API

A simple library RESTful API, made with Laravel for a MySQL database.

![Laravel](https://img.shields.io/badge/Laravel-2e2e2e?logo=laravel)
![MySQL](https://img.shields.io/badge/MySQL-2e2e2e?logo=mysql)


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

- Install dependencies

    ```bash
    ./vendor/bin/composer install
    ```

- Make a new MySQL database, and name it library
- Copy and add your connection details to the `.env` file

    ```bash
    cp .env.example .env
    ```

- Generate your new app key

    ```bash
    php artisan key:generate
    ```

- Migrate the tables to your database

    ```bash
    php artisan migrate
    ```

- Add dummy data to your database (optional)

    ```bash
    php artisan tinker
    ```

    ```php
    Book::factory()->count(100)->create()
    ```

- Run the app on your local port

    ```bash
    php artisan serve
    ```
