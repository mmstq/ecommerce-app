# E-Commerce API Application

A Laravel-based e-commerce API application with authentication and product management features.

## 1. Dependencies Used

### PHP Dependencies (Composer)

**Production Dependencies:**
- `php`: ^8.1
- `laravel/framework`: ^10.10 - The Laravel framework
- `laravel/sanctum`: ^3.3 - API authentication using token-based authentication
- `guzzlehttp/guzzle`: ^7.2 - HTTP client library
- `laravel/tinker`: ^2.8 - REPL for Laravel

**Development Dependencies:**
- `fakerphp/faker`: ^1.9.1 - Fake data generator for testing
- `laravel/pint`: ^1.0 - Laravel's code style fixer
- `laravel/sail`: ^1.18 - Docker development environment
- `mockery/mockery`: ^1.4.4 - Mocking framework for testing
- `nunomaduro/collision`: ^7.0 - Error handler
- `phpunit/phpunit`: ^10.1 - PHP testing framework
- `spatie/laravel-ignition`: ^2.0 - Error page handler

### JavaScript Dependencies (NPM)

**Development Dependencies:**
- `vite`: ^5.0.0 - Next generation frontend build tool
- `laravel-vite-plugin`: ^1.0.0 - Vite plugin for Laravel
- `axios`: ^1.6.4 - HTTP client for JavaScript

## 2. How to Run

### Prerequisites
- PHP >= 8.1
- Composer
- Node.js and NPM
- SQLite (included with PHP)

### Installation Steps

1. **Clone the repository** (if applicable) or navigate to the project directory:
   ```bash
   cd /home/zuko/ecommerce-app
   ```

2. **Install PHP dependencies:**
   ```bash
   composer install
   ```

3. **Install JavaScript dependencies:**
   ```bash
   npm install
   ```

4. **Set up environment file:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure database in `.env` file:**
   ```env
   DB_CONNECTION=sqlite

   ```
   Or use the default path:
   ```env
   DB_CONNECTION=sqlite
   ```

6. **Run database migrations:**
   ```bash
   php artisan migrate
   ```

7. **Start the development server:**
   ```bash
   npm run dev
   php artisan serve
   ```
   The application will be available at `http://localhost:8000`

8. **Build frontend assets (if needed):**
   ```bash
   npm run dev
   ```
   Or for production:
   ```bash
   npm run build
   ```

## 3. Use of Serverless SQLite

This application uses **SQLite** as the database, which is a serverless, file-based database system. This means:

- **No separate database server required**: SQLite stores data in a single file (`database/database.sqlite`)
- **Zero configuration**: No need to set up MySQL, PostgreSQL, or any other database server
- **Perfect for development**: Ideal for local development, testing, and small to medium applications
- **Portable**: The entire database is contained in one file, making it easy to backup and transfer
- **Lightweight**: Minimal resource usage compared to traditional database servers

The SQLite database file is located at: `database/database.sqlite`

**Note**: Ensure the database file exists and has proper write permissions. If the file doesn't exist, Laravel will create it automatically when you run migrations.

## 4. How to Run Seeder

The application includes a `ProductSeeder` that generates 50 fake products using the ProductFactory.

### Run the seeder:

```bash
php artisan db:seed
```

Or specifically run only the ProductSeeder:

```bash
php artisan db:seed --class=ProductSeeder
```

### What the seeder does:

- Creates 50 products with fake data including:
  - Title
  - Description
  - Price
  - Discount (percentage)
  - Image URL

### Reset and reseed the database:

If you want to refresh the database and reseed:

```bash
php artisan migrate:fresh --seed
```

**Warning**: This will drop all tables and recreate them, losing all existing data.

## 5. API Endpoints

All API endpoints are prefixed with `/api`. The base URL is: `http://localhost:8000/api`

### Authentication Endpoints

#### 1. Register User
- **URL**: `POST /api/register`
- **Authentication**: Not required
- **Request Body**:
  ```json
  {
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123"
  }
  ```
- **Validation Rules**:
  - `name`: required, string, max 255 characters
  - `email`: required, valid email, max 255 characters, must be unique
  - `password`: required, string, minimum 8 characters
- **Response**:
  ```json
  {
    "status": true,
    "token": "1|xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx",
    "user": {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com",
      ...
    }
  }
  ```

#### 2. Login User
- **URL**: `POST /api/login`
- **Authentication**: Not required
- **Request Body**:
  ```json
  {
    "email": "john@example.com",
    "password": "password123"
  }
  ```
- **Validation Rules**:
  - `email`: required, valid email
  - `password`: required
- **Response** (Success):
  ```json
  {
    "status": true,
    "token": "2|xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx",
    "user": {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com",
      ...
    }
  }
  ```
- **Response** (Error - 422):
  ```json
  {
    "message": "The provided credentials do not match our records.",
    "errors": {
      "email": ["The provided credentials do not match our records."]
    }
  }
  ```

### Protected Endpoints (Require Authentication)

#### 3. Get Authenticated User
- **URL**: `GET /api/user`
- **Authentication**: Required (Sanctum token)
- **Headers**:
  ```
  Authorization: Bearer {token}
  Accept: application/json
  ```
- **Response**:
  ```json
  {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    ...
  }
  ```

### Product Endpoints

#### 4. Get Products List
- **URL**: `GET /api/products`
- **Authentication**: Not required
- **Query Parameters**: None (uses pagination)
- **Response**:
  ```json
  {
    "current_page": 1,
    "data": [
      {
        "id": 1,
        "title": "Product Title",
        "description": "Product description",
        "price": "99.99",
        "discount": "10.00",
        "image_url": "https://example.com/image.jpg",
        "price_after_discount": 89.99,
        "created_at": "2024-01-01T00:00:00.000000Z",
        "updated_at": "2024-01-01T00:00:00.000000Z"
      },
      ...
    ],
    "first_page_url": "http://localhost:8000/api/products?page=1",
    "from": 1,
    "last_page": 5,
    "last_page_url": "http://localhost:8000/api/products?page=5",
    "links": [...],
    "next_page_url": "http://localhost:8000/api/products?page=2",
    "path": "http://localhost:8000/api/products",
    "per_page": 10,
    "prev_page_url": null,
    "to": 10,
    "total": 50
  }
  ```
- **Pagination**: Returns 10 products per page by default

## 6. Important Data to Highlight

### Authentication System
- **Laravel Sanctum** is used for API token authentication
- Tokens are returned upon successful registration or login
- Include the token in the `Authorization` header as `Bearer {token}` for protected routes
- Tokens are stored in the `personal_access_tokens` table

### Product Model Features
- **Automatic Price Calculation**: The Product model includes a computed attribute `price_after_discount` that automatically calculates the final price after applying the discount percentage
- **Product Fields**:
  - `id`: Primary key
  - `title`: Product name (required)
  - `description`: Product description (nullable)
  - `price`: Product price in decimal format (10,2)
  - `discount`: Discount percentage (5,2) - defaults to 0
  - `image_url`: Product image URL (nullable)
  - `created_at` & `updated_at`: Timestamps

### Database Structure
- **Users Table**: Stores user authentication data
- **Products Table**: Stores product information
- **Personal Access Tokens Table**: Stores Sanctum authentication tokens
- **Password Reset Tokens Table**: For password reset functionality
- **Failed Jobs Table**: For queue job failures

### API Response Format
- All API responses return JSON
- Authentication endpoints include a `status: true` field in successful responses
- Error responses follow Laravel's validation error format

### Testing
- The application includes PHPUnit test setup
- Test files are located in the `tests/` directory
- Run tests with: `php artisan test` or `vendor/bin/phpunit`

### Development Tools
- **Laravel Tinker**: Use `php artisan tinker` to interact with the application via REPL
- **Laravel Pint**: Code style fixer (run with `./vendor/bin/pint`)
- **Laravel Sail**: Docker development environment (if using Docker)

---

## Additional Notes

- The API uses Laravel's built-in pagination for product listings
- All timestamps are in UTC format
- The application follows Laravel 10 conventions and best practices
- CORS is configured in `config/cors.php` for cross-origin requests
