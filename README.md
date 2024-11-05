# Member Management Backend

## Overview
This project is a member management backend built using Laravel. It includes two separate dashboards: an Admin Dashboard for administrators and a User Dashboard for general users. The system includes functionalities for managing blogs, events, news, products, and categories, integrating an e-commerce payment system via Chapa, and offering membership payment options. Users can also register for events directly through the platform.

## Key Features

### Admin Dashboard
- **Blog Management**: Admins can create, read, update, and delete blog posts.
- **Event Management**: Admins can add, view, edit, and remove events.
- **News Management**: Admins can post news updates, view details, edit content, and delete news posts.
- **E-commerce Management**:
  - **Product Management**: Admins can add, edit, view, and delete products.
  - **Category Management**: Admins can create, update, view, and delete product categories.

### User Dashboard
- **E-commerce Payment System**: Integrated with Chapa, allowing users to purchase products securely.
- **Membership Payment System**: Users can pay for membership using the payment integration.
- **Event Registration**: Users can register for events organized by the platform.

## Tech Stack
- **Backend**: Laravel (PHP Framework)
- **Database**: MySQL (or compatible database)
- **Payment Integration**: Chapa

## Setup and Installation

1. **Clone the Repository**
   ```bash
   git clone https://github.com/your-username/your-repo-name.git

## Setup and Installation

2. **Install Dependencies**
   ```bash
   cd your-repo-name
   composer install
   ```
3. **Set up Environment Variables**:
  Duplicate .env.example and rename it to .env.//

4. **Generate Application Key**
   ```bash
   php artisan key:generate

5. **Run Migrations**
   ```bash
   php artisan migrate

6. **Run Seeder (Optional)**
   ```bash
   php artisan db:seed


7. **Start the Server**
   ```bash
   php artisan serve

8. **Access the Application**:
  Go to http://localhost:8000 to access the application.

## Usage

### Admin Dashboard
- Login as an admin to access the admin dashboard.
- Manage blogs, events, news, products, and categories through CRUD operations.

### User Dashboard
- Register or login to access the user dashboard.
- Use the e-commerce payment system to purchase products.
- Use the membership payment system to become a member.
- Register for events directly from the user dashboard.

## API Endpoints
The backend provides RESTful API endpoints for various features:

- **Blog Management**: `/api/admin/blogs`
- **Event Management**: `/api/admin/events`
- **News Management**: `/api/admin/news`
- **Product Management**: `/api/admin/products`
- **Category Management**: `/api/admin/categories`
- **User Registration and Login**: `/api/user/auth`
- **Payment Processing**: `/api/user/payments`

*(Refer to the detailed API documentation for more endpoint information.)*

## License
This project is licensed under the MIT License. See the LICENSE file for details.

## Contributions
Contributions, issues, and feature requests are welcome! Feel free to check the issues page.
