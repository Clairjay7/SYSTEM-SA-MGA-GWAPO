# PHP RESTful API System

A complete RESTful API implementation using core PHP for managing products and orders with proper authentication.

## Project Structure

```
├── api/
│   ├── auth/
│   │   ├── AuthController.php
│   │   └── JWTHandler.php
│   ├── controllers/
│   │   ├── ProductController.php
│   │   └── OrderController.php
│   ├── database/
│   │   ├── Database.php
│   │   └── test_setup.sql
│   ├── models/
│   │   ├── Product.php
│   │   └── Order.php
│   ├── utils/
│   │   ├── Response.php
│   │   └── Validator.php
│   ├── .htaccess
│   └── Router.php
├── API_ACTIVITY.md
└── README.md
```

## Setup Instructions

1. **Prerequisites**
   - XAMPP (with PHP 7.4+ and MySQL)
   - Postman for API testing

2. **Database Setup**
   - Start MySQL server in XAMPP
   - Navigate to phpMyAdmin
   - Import `api/database/test_setup.sql`

3. **Project Setup**
   - Clone repository to XAMPP's htdocs folder
   - Ensure proper file permissions
   - Configure virtual host (optional)

4. **Testing the API**
   - Use provided Postman collection
   - Start with authentication endpoint
   - Test CRUD operations with received token

## Authentication

The system uses JWT (JSON Web Tokens) for authentication. To get started:

1. Login with test credentials:
   - Username: `admin`
   - Password: `password`

2. Use the received token in subsequent requests:
   ```
   Authorization: Bearer <your_token>
   ```

## API Documentation

Detailed API documentation is available in the `API_ACTIVITY.md` file.

## Security Features

- JWT-based authentication
- Role-based access control
- Input validation and sanitization
- Prepared statements for SQL queries
- CORS headers
- Proper error handling

## Development Guidelines

1. Follow RESTful principles
2. Implement proper error handling
3. Use prepared statements
4. Validate all inputs
5. Return appropriate HTTP status codes
6. Format responses in JSON

## Testing

Use the provided Postman collection to test:
1. Authentication flow
2. Product CRUD operations
3. Order management
4. Error handling
5. Access control

## Troubleshooting

Common issues and solutions:

1. **Database Connection**
   - Verify MySQL is running
   - Check database credentials
   - Ensure database exists

2. **Authentication Issues**
   - Verify token format
   - Check token expiration
   - Confirm user permissions

3. **CORS Issues**
   - Check Origin headers
   - Verify CORS configuration
   - Test with allowed domains

## Contributing

1. Fork the repository
2. Create feature branch
3. Commit changes
4. Push to branch
5. Create pull request 