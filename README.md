# Simple Subscription Platform - API Documentation

This documentation provides an overview of the RESTful APIs for the Simple Subscription Platform. This platform allows users to subscribe to various websites and receive email notifications whenever a new post is published on a subscribed website.

## Project Setup

To set up the project, follow these steps:

1. Install project dependencies using Composer:
   ```sh
   composer install
   ```

2. Create a `.env` file by copying the example:
   ```sh
   cp .env.example .env
   ```

3. Generate a unique application key:
   ```sh
   php artisan key:generate
   ```

4. Run database migrations to create the necessary tables:
   ```sh
   php artisan migrate
   ```

5. Seed the database with initial data:
   ```sh
   php artisan db:seed
   ```

## Creating a Subscriber

**Endpoint:** `POST /api/subscriber`

**Request Body:**
```json
{
  "email": "example@example.com",
  "website_id": 1
}
```

This API allows users to subscribe to a specific website using their email address. Provide the `email` and `website_id` in the request body.

## Showing Websites

**Endpoint:** `GET /api/website`

This API endpoint returns a list of available websites in the system. Users can use this information to choose which websites they want to subscribe to.

## Creating a Page

**Endpoint:** `POST /api/post/create`

**Request Body:**
```json
{
  "title": "example",
  "content": "example",
  "website_id": 1
}
```

Use this API to create a new post on a specific website. Provide the `title`, `content`, and `website_id` in the request body.

## Sending Emails

To send email notifications to subscribers about new posts, run the following command:
```sh
php artisan send:mail
```

This command triggers the system to send emails to all subscribers of each website whenever a new post is published.

---
