# API Documentation

## Base URL
```
http://localhost/SYSTEM-SA-MGA-GWAPO/api
```

## Authentication
The API uses token-based authentication. To access protected endpoints, include the token in the Authorization header:
```
Authorization: Bearer your_token_here
```

### Authentication Endpoints

#### Login
```
POST /auth/login
Content-Type: application/json

Request Body:
{
    "username": "admin",
    "password": "password"
}

Response:
{
    "status": "success",
    "data": {
        "token": "your_jwt_token",
        "user": {
            "id": 1,
            "username": "admin",
            "role": "admin"
        }
    }
}
```

#### Guest Access
```
POST /auth/guest
Content-Type: application/json

Response:
{
    "status": "success",
    "data": {
        "token": "guest_jwt_token",
        "user": {
            "id": "guest_id",
            "role": "guest"
        }
    }
}
```

### User Endpoints (Protected)

#### Get All Users
```
GET /users
Authorization: Bearer token
```

#### Get User by ID
```
GET /users/{id}
Authorization: Bearer token
```

#### Update User
```
PUT /users/{id}
Authorization: Bearer token
Content-Type: application/json

Request Body:
{
    "username": "newusername",
    "email": "newemail@example.com"
}
```

#### Delete User
```
DELETE /users/{id}
Authorization: Bearer token
```

### Product Endpoints

#### Get All Products
```
GET /products
```

#### Get Product by ID
```
GET /products/{id}
```

#### Create Product (Protected)
```
POST /products
Authorization: Bearer token
Content-Type: application/json

Request Body:
{
    "name": "Product Name",
    "description": "Product Description",
    "price": 99.99
}
```

#### Update Product (Protected)
```
PUT /products/{id}
Authorization: Bearer token
Content-Type: application/json

Request Body:
{
    "name": "Updated Name",
    "price": 149.99
}
```

#### Delete Product (Protected)
```
DELETE /products/{id}
Authorization: Bearer token
```

### Order Endpoints (Protected)

#### Get All Orders
```
GET /orders
Authorization: Bearer token
```

#### Get Order by ID
```
GET /orders/{id}
Authorization: Bearer token
```

#### Create Order
```
POST /orders
Authorization: Bearer token
Content-Type: application/json

Request Body:
{
    "products": [
        {
            "product_id": 1,
            "quantity": 2
        }
    ]
}
```

#### Update Order
```
PUT /orders/{id}
Authorization: Bearer token
Content-Type: application/json

Request Body:
{
    "status": "completed"
}
```

#### Delete Order
```
DELETE /orders/{id}
Authorization: Bearer token
```

## Response Format

### Success Response
```json
{
    "status": "success",
    "code": 200,
    "message": "Success message",
    "data": {
        // Response data here
    }
}
```

### Error Response
```json
{
    "status": "error",
    "code": 400,
    "message": "Error message",
    "errors": {
        // Detailed error information
    }
}
```

## Error Codes
- 200: Success
- 400: Bad Request
- 401: Unauthorized
- 403: Forbidden
- 404: Not Found
- 500: Internal Server Error

## Testing with Postman
1. Import the provided Postman collection
2. Set up environment variables:
   - `base_url`: http://localhost/SYSTEM-SA-MGA-GWAPO/api
   - `token`: Your authentication token
3. Use the collection to test all endpoints 