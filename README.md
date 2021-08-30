# A simple 📚 library API

A simple library RESTful API, made with Laravel for a MySQL database.

![Laravel](https://img.shields.io/badge/Laravel-2e2e2e?logo=laravel)
![MySQL](https://img.shields.io/badge/MySQL-2e2e2e?logo=mysql)

## 📄 API Specs

Please see [`/tests/Feature/BookApiTest.php`](https://github.com/lucaxue/library-api/blob/main/tests/Feature/BooksApiTest.php)

### Route: `/api/books`

| HTTP Method | Endpoint      | Action                             |
| ----------- | ------------- | ---------------------------------- |
| **GET**     | `/`           | Get all books                      |
| **GET**     | `/{id}`       | Get book by id                     |
| **GET**     | `?search=foo` | Search books by title or author    |
| **GET**     | `?page=3`     | Paginate books (15 books per page) |
| **POST**    | `/`           | Store a new book                   |
| **PUT**     | `/{id}`       | Update an existing book            |
| **DELETE**  | `/{id}`       | Delete a book                      |

<br>

<details>

<summary><strong>⚙️ Setting Up</strong></summary>

-   Install dependencies

    ```bash
    ./vendor/bin/composer install
    ```

-   Make a new MySQL database, and name it library
-   Copy and add your connection details to the `.env` file

    ```bash
    cp .env.example .env
    ```

-   Generate your new app key

    ```bash
    php artisan key:generate
    ```

-   Migrate the tables to your database

    ```bash
    php artisan migrate
    ```

-   Add dummy data to your database (optional)

    ```bash
    php artisan tinker
    ```

    ```php
    Book::factory()->count(100)->create()
    ```

-   Run the app on your local port

    ```bash
    php artisan serve
    ```

</details>

<details>

<summary><strong>🧪 Tests</strong></summary>

-   Run the tests

    ```bash
    php artisan test
    ```

</details>
