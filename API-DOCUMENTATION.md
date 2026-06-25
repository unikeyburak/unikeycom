# Unikeyterra API Documentation

## Base URL
```
https://yourdomain.com/api/v1
```

## Authentication

The API uses Bearer token authentication. Include your API token in the Authorization header:

```
Authorization: Bearer YOUR_API_TOKEN
```

## Endpoints

### Public Endpoints (No Authentication Required)

#### Categories

##### Get All Categories
```
GET /categories
```

Response:
```json
{
  "success": true,
  "message": "Categories retrieved successfully",
  "data": [
    {
      "id": 1,
      "parent_id": null,
      "name": "Gübreler",
      "slug": "gubreler",
      "description": "Tarımsal gübre çeşitleri",
      "status": "active",
      "products_count": 25,
      "created_at": "2024-01-01T00:00:00Z"
    }
  ]
}
```

##### Get Category Details
```
GET /categories/{id}
```

##### Get Products by Category
```
GET /categories/{id}/products?per_page=15
```

#### Products

##### Get All Products
```
GET /products?per_page=15&category_id=1
```

Response:
```json
{
  "success": true,
  "message": "Products retrieved successfully",
  "data": [
    {
      "id": 1,
      "category_id": 1,
      "category": {
        "id": 1,
        "name": "Gübreler"
      },
      "name": "MaxiGuard 500 SC",
      "slug": "maxiguard-500-sc",
      "sku": "FNG-001",
      "short_description": "Sistemik ve koruyucu etkili geniş spektrumlu fungisit",
      "active_ingredient": "500 g/l Azoxystrobin",
      "formulation": "SC (Süspansiyon Konsantre)",
      "status": "active",
      "is_featured": true
    }
  ],
  "meta": {
    "current_page": 1,
    "last_page": 5,
    "per_page": 15,
    "total": 75,
    "from": 1,
    "to": 15
  },
  "links": {
    "first": "https://yourdomain.com/api/v1/products?page=1",
    "last": "https://yourdomain.com/api/v1/products?page=5",
    "prev": null,
    "next": "https://yourdomain.com/api/v1/products?page=2"
  }
}
```

##### Get Product Details
```
GET /products/{id}
```

##### Search Products
```
GET /products/search?q=fungisit&per_page=15
```

### Authentication Endpoints

#### Login
```
POST /auth/login
```

Request:
```json
{
  "email": "dealer@example.com",
  "password": "password123"
}
```

Response:
```json
{
  "success": true,
  "message": "Login successful",
  "data": {
    "user": {
      "id": 1,
      "name": "John Doe",
      "email": "dealer@example.com",
      "dealer_id": 5
    },
    "token": "YOUR_API_TOKEN",
    "token_type": "Bearer"
  }
}
```

#### Register Dealer
```
POST /auth/register
```

Request:
```json
{
  "company_name": "ABC Tarım Ltd. Şti.",
  "tax_number": "1234567890",
  "tax_office": "Konak",
  "phone": "02321234567",
  "email": "info@abctarim.com",
  "website": "www.abctarim.com",
  "address": "Test Cad. No:123",
  "city": "İzmir",
  "district": "Konak",
  "postal_code": "35000",
  "about": "Tarım ürünleri satışı"
}
```

### Protected Endpoints (Authentication Required)

#### User Profile

##### Get Current User
```
GET /auth/me
```

##### Update Profile
```
PUT /auth/profile
```

Request:
```json
{
  "name": "John Doe Updated",
  "phone": "05551234567"
}
```

##### Change Password
```
POST /auth/change-password
```

Request:
```json
{
  "current_password": "oldpassword",
  "new_password": "newpassword123",
  "new_password_confirmation": "newpassword123"
}
```

#### Dealer

##### Get Dealer Profile
```
GET /dealer/profile
```

##### Update Dealer Profile
```
PUT /dealer/profile
```

Request:
```json
{
  "phone": "02329999999",
  "website": "www.newwebsite.com",
  "working_hours": {
    "monday": "08:00-18:00",
    "tuesday": "08:00-18:00"
  },
  "social_media": {
    "facebook": "abctarim",
    "instagram": "abctarim"
  }
}
```

#### Orders

##### Get Orders
```
GET /orders?per_page=15&status=pending
```

##### Create Order
```
POST /orders
```

Request:
```json
{
  "items": [
    {
      "product_id": 1,
      "quantity": 10,
      "notes": "Urgent delivery needed"
    },
    {
      "product_id": 5,
      "quantity": 25
    }
  ],
  "notes": "Please deliver to warehouse B"
}
```

##### Get Order Details
```
GET /orders/{id}
```

##### Update Order
```
PUT /orders/{id}
```

Request:
```json
{
  "items": [
    {
      "product_id": 1,
      "quantity": 15,
      "notes": "Updated quantity"
    }
  ],
  "notes": "Updated delivery notes"
}
```

##### Cancel Order
```
DELETE /orders/{id}
```

#### API Tokens

##### Get API Tokens
```
GET /tokens
```

##### Create API Token
```
POST /tokens
```

Request:
```json
{
  "name": "Mobile App Token",
  "abilities": ["read", "write"],
  "expires_at": "2024-12-31T23:59:59Z"
}
```

Response:
```json
{
  "success": true,
  "message": "Token created successfully",
  "data": {
    "token": "NEW_API_TOKEN_HERE",
    "token_info": {
      "id": 1,
      "name": "Mobile App Token",
      "abilities": ["read", "write"],
      "expires_at": "2024-12-31T23:59:59Z",
      "status": "active"
    }
  }
}
```

##### Revoke API Token
```
DELETE /tokens/{id}
```

## Error Responses

All error responses follow this format:

```json
{
  "success": false,
  "message": "Error message here",
  "errors": {
    "field_name": ["Error message for this field"]
  }
}
```

### Common HTTP Status Codes

- `200` - OK
- `201` - Created
- `204` - No Content
- `400` - Bad Request
- `401` - Unauthorized
- `403` - Forbidden
- `404` - Not Found
- `422` - Validation Error
- `500` - Internal Server Error

## Rate Limiting

API requests are limited to 60 requests per minute per API token. Rate limit information is included in response headers:

```
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 58
X-RateLimit-Reset: 1640995200
```

## Pagination

List endpoints support pagination with these query parameters:

- `page` - Page number (default: 1)
- `per_page` - Items per page (default: 15, max: 100)

## Filtering & Sorting

Most list endpoints support filtering and sorting:

- `sort` - Sort field and direction (e.g., `name`, `-created_at`)
- `filter[field]` - Filter by field value

## Localization

The API supports Turkish and English. Set the `Accept-Language` header:

```
Accept-Language: tr
Accept-Language: en
```