# Eventify - Event Management Platform

Eventify's Backend code base built with Laravel PHP.

## Table of Contents

- [Prerequisites](#prerequisites)
- [Installation](#installation)
- [Usage](#usage)


### Prerequisites

- PHP >= 8.3
- Composer
- MySQL (or any other supported database)

## Installation

If you are using Laragon, XAMPP, or similar tools, make sure to first navigate to the /www or /htdocs directories before proceeding.

1. Clone the repository:
    ```sh
    git clone https://github.com/Abdallah01win/Eventify-api.git
    ```
2. Navigate into the project directory:
    ```sh
    cd Eventify-api
    ```
3. Copy the `.env.example` file to `.env`:
    ```sh
    cp .env.example .env
    ```
4. Install the dependencies:
    ```sh
    composer install
    ```
5. Generate the application key:
    ```sh
    php artisan key:generate
    ```

6. Run the migrations and seeders:
    ```sh
    php artisan migrate --seed
    ```

## Usage

### Using Laragon or XAMPP

1. Start Laragon or XAMPP.

2. Ensure that Apache or NGINX and MySQL services are running.

3. Open your browser and navigate to `http://Eventify-api.test:8080/`.

(The exact URL varies for each application. Consult your application to get the exact URL)

### Using PHP's Built-in Server

1. Start the development server:
    ```sh
    php artisan serve
    ```
2. Follow the URL outputted in your terminal to access the application.

### Front-End Integration

To use the front-end Interface for this API:

1. Install the [Eventify-app](https://github.com/Abdallah01win/Eventify-app) repository.

2. Past your local API URL from the previous step into the .env file.
