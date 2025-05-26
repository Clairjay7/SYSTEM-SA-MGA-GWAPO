# Hot Wheels Store API Documentation

## Base URL
```
http://your-domain.com/api/v1
```

## Authentication
All API requests require authentication using JWT (JSON Web Token). Include the token in the Authorization header:
```
Authorization: Bearer <your_jwt_token>
```

## Error Responses
All endpoints may return these error responses:
```json
{
    "status": "error",
    "code": 401,
    "message": "Unauthorized access"
}
```
```json
{
    "status": "error",
    "code": 403,
    "message": "Forbidden - Insufficient permissions"
}
```
```json
{
    "status": "error",
    "code": 404,
    "message": "Resource not found"
}
```
```json
{
    "status": "error",
    "code": 500,
    "message": "Internal server error"
}
```

## Endpoints

### Authentication

#### POST /auth/login
Login to get access token.

**Request:**
```json
{
    "username": "string",
    "password": "string"
}
```

**Response:**
```json
{
    "status": "success",
    "data": {
        "token": "jwt_token_here",
        "user": {
            "id": 1,
            "username": "string",
            "role": "admin|user"
        }
    }
}
```

### Users

#### GET /users
Get all users (Admin only)

**Response:**
```json
{
    "status": "success",
    "data": {
        "users": [
            {
                "id": 1,
                "username": "string",
                "email": "string",
                "role": "string",
                "created_at": "timestamp"
            }
        ]
    }
}
```

#### POST /users
Create new user (Admin only)

**Request:**
```json
{
    "username": "string",
    "email": "string",
    "password": "string",
    "role": "admin|user"
}
```

### Products

#### GET /products
Get all products

**Response:**
```json
{
    "status": "success",
    "data": {
        "products": [
            {
                "id": 1,
                "name": "string",
                "price": "number",
                "image_url": "string",
                "stock": "number"
            }
        ]
    }
}
```

#### POST /products
Add new product (Admin only)

**Request:**
```json
{
    "name": "string",
    "price": "number",
    "image_url": "string",
    "stock": "number"
}
```

### Orders

#### GET /orders
Get all orders (Admin) or user's orders (User)

**Response:**
```json
{
    "status": "success",
    "data": {
        "orders": [
            {
                "id": 1,
                "user_id": "number",
                "total_amount": "number",
                "status": "string",
                "created_at": "timestamp",
                "items": [
                    {
                        "product_id": "number",
                        "quantity": "number",
                        "price": "number"
                    }
                ]
            }
        ]
    }
}
```

#### POST /orders
Create new order

**Request:**
```json
{
    "items": [
        {
            "product_id": "number",
            "quantity": "number"
        }
    ]
}
```

## Rate Limiting
API requests are limited to 100 requests per minute per IP address.

## Versioning
Current API version: v1 