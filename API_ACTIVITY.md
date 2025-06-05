# API Design and Implementation Activity

## Overview
In this activity, you will work with a PHP-based RESTful API system that implements CRUD (Create, Read, Update, Delete) operations for managing users, products, and orders. The system uses a MySQL database and implements proper authentication using JWT tokens.

## Prerequisites
- XAMPP installed with PHP and MySQL
- Postman for API testing
- Basic understanding of RESTful APIs and HTTP methods
- Knowledge of PHP and MySQL

## Database Structure
The system uses a MySQL database named `galorpot` with the following tables:
- `users`: Stores user information and authentication details
- `products`: Manages product inventory
- `orders`: Tracks customer orders
- `order_items`: Stores individual items within orders

## API Endpoints

### Authentication
1. **Login**
   - Endpoint: `POST /api/auth/login`
   - Purpose: Authenticate users and receive JWT token
   - Request body:
     ```json
     {
         "username": "admin",
         "password": "password"
     }
     ```

### Products
1. **Get All Products**
   - Endpoint: `GET /api/products`
   - Purpose: Retrieve list of all active products

2. **Get Single Product**
   - Endpoint: `GET /api/products/{id}`
   - Purpose: Retrieve details of a specific product

3. **Create Product** (Admin only)
   - Endpoint: `POST /api/products`
   - Purpose: Add a new product
   - Request body:
     ```json
     {
         "name": "New Product",
         "description": "Product description",
         "price": 99.99,
         "stock": 100
     }
     ```

4. **Update Product** (Admin only)
   - Endpoint: `PUT /api/products/{id}`
   - Purpose: Update existing product details

5. **Delete Product** (Admin only)
   - Endpoint: `DELETE /api/products/{id}`
   - Purpose: Soft delete a product

### Orders
1. **Create Order**
   - Endpoint: `POST /api/orders`
   - Purpose: Place a new order
   - Request body:
     ```json
     {
         "items": [
             {
                 "product_id": 1,
                 "quantity": 2
             }
         ]
     }
     ```

2. **Get User Orders**
   - Endpoint: `GET /api/orders`
   - Purpose: Retrieve all orders for authenticated user

3. **Get Order Details**
   - Endpoint: `GET /api/orders/{id}`
   - Purpose: Get detailed information about specific order

## Tasks

### 1. API Implementation (40 points)
- [ ] Implement all CRUD endpoints for products (15 points)
- [ ] Implement order creation and retrieval endpoints (15 points)
- [ ] Add proper error handling and validation (10 points)

### 2. Authentication & Security (30 points)
- [ ] Implement JWT token-based authentication (15 points)
- [ ] Add role-based access control (admin vs user) (10 points)
- [ ] Implement proper input validation and sanitization (5 points)

### 3. Testing & Documentation (30 points)
- [ ] Create Postman collection for all endpoints (10 points)
- [ ] Add comprehensive error messages and logging (10 points)
- [ ] Document all API endpoints and their usage (10 points)

## Testing Instructions

1. **Setup Database**
   - Run the provided `test_setup.sql` script to create database and test data
   - Default admin credentials: username: "admin", password: "password"

2. **Test Authentication**
   - Use Postman to get JWT token from login endpoint
   - Include token in subsequent requests using Bearer authentication

3. **Test CRUD Operations**
   - Test each endpoint with valid and invalid data
   - Verify proper error handling
   - Check role-based access control

## Evaluation Criteria
1. Proper implementation of CRUD operations
2. Secure authentication and authorization
3. Error handling and input validation
4. Code organization and clarity
5. API documentation and testing

## Submission Requirements
1. Complete source code
2. Database setup scripts
3. Postman collection for testing
4. Documentation of API endpoints
5. Implementation report highlighting security measures

## Notes
- All responses must be in JSON format
- Implement proper HTTP status codes
- Include CORS headers for cross-origin requests
- Use prepared statements for database queries
- Implement proper logging for debugging 