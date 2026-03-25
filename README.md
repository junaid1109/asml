# AMS - Professional Business Website (Laravel)

A complete Laravel application conversion of the AMS Bootstrap template with a full-featured admin panel and MySQL database.

## Features

### Frontend
- **Home Page** - Hero section, services preview, team display
- **About Page** - Company information with team members
- **Services** - Complete service listing and detail pages
- **Team** - Team members showcase with social links
- **Contact** - Contact form with database storage
- **Static Pages** - Customizable pages for Terms, Privacy, etc.

### Admin Panel
- **Dashboard** - Overview statistics and recent messages
- **Services Management** - Full CRUD for services with icons and images
- **Team Members** - Manage team profiles and social links
- **Pages Management** - Create and edit custom pages
- **Contacts** - View and manage contact form submissions
- **Settings** - Configure site information and social media links
- **User Authentication** - Secure login and registration system

## Installation & Setup

### Prerequisites
- PHP 8.0 or higher
- Composer
- MySQL 5.7 or higher
- XAMPP or similar (with Apache & MySQL)

### Step 1: Initial Setup

1. Navigate to your XAMPP htdocs directory:
```bash
cd d:\xampp\htdocs\project\sanq\mike\Axis-Laravel
```

2. Install Composer dependencies:
```bash
composer install
```

3. Copy the environment file:
```bash
cp .env.example .env
```

4. Generate application key:
```bash
php artisan key:generate
```

### Step 2: Database Configuration

1. Update your `.env` file with database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sanchiro_ams
DB_USERNAME=root
DB_PASSWORD=
```

2. Create the database in MySQL:
```sql
CREATE DATABASE sanchiro_ams;
```

3. Run migrations to create tables:
```bash
php artisan migrate
```

### Step 3: Create Admin User

Create your first admin user:
```bash
php artisan tinker
```

Then in the Tinker console:
```php
App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@ams.com',
    'password' => bcrypt('password'),
    'role' => 'admin'
]);
```

Or use the register page at `/register`

### Step 4: Copy Assets

Copy the assets from the original AMS folder to your new Laravel project:
```bash
# Copy the assets directory
xcopy "d:\xampp\htdocs\project\sanq\mike\Axis\assets" "d:\xampp\htdocs\project\sanq\mike\Axis-Laravel\public\assets" /E /I /Y
```

### Step 5: Configure Storage

Create a symbolic link for storage:
```bash
php artisan storage:link
```

### Step 6: Start the Development Server

```bash
php artisan serve
```

Then visit: `http://localhost:8000`

## Frontend Routes

| Route | Path | Description |
|-------|------|-------------|
| Home | `/` | Homepage |
| About | `/about` | About us page |
| Services | `/services` | Services listing |
| Service Detail | `/services/{slug}` | Service details |
| Team | `/team` | Team members |
| Contact | `/contact` | Contact form |
| Contact Submit | `POST /contact` | Submit contact form |
| Static Pages | `/{slug}` | Custom pages (terms, privacy, etc.) |

## Admin Routes

All admin routes are prefixed with `/admin` and require authentication.

| Route | Path | Description |
|-------|------|-------------|
| Dashboard | `/admin/dashboard` | Admin dashboard |
| Services | `/admin/services` | Services management |
| Team Members | `/admin/team` | Team management |
| Pages | `/admin/pages` | Pages management |
| Contacts | `/admin/contacts` | Contact submissions |
| Settings | `/admin/settings` | Site settings |

## Authentication Routes

| Route | Path | Description |
|-------|------|-------------|
| Login | `/login` | Admin login |
| Register | `/register` | Create new admin account |
| Logout | `POST /logout` | Logout (authenticated users) |

## Database Schema

### Users Table
- id
- name
- email (unique)
- password
- role
- timestamps

### Services Table
- id
- title
- slug (unique)
- description
- short_description
- icon (CSS class)
- image
- features (HTML)
- pricing (HTML)
- published
- order
- timestamps

### Team Members Table
- id
- name
- position
- bio
- image
- email
- phone
- twitter (URL)
- linkedin (URL)
- facebook (URL)
- instagram (URL)
- published
- order
- timestamps

### Contacts Table
- id
- name
- email
- phone
- subject
- message
- is_read
- timestamps

### Pages Table
- id
- title
- slug (unique)
- content (HTML)
- image
- meta_description
- meta_keywords
- published
- page_type (static, about, terms, privacy)
- timestamps

### Settings Table
- id
- key (unique)
- value
- timestamps

## Customization

### Adding New Admin Pages

1. Create a new Model in `app/Models/`
2. Create a migration in `database/migrations/`
3. Create a Controller in `app/Http/Controllers/Admin/`
4. Add routes in `routes/web.php`
5. Create views in `resources/views/admin/`

### Adding New Frontend Pages

1. Create a Page via the admin panel, or:
2. Use the PageController to display custom pages from the database

### Customizing Styling

Main CSS file: `public/assets/css/main.css`

To customize the admin panel, edit the styles in `resources/views/layouts/admin.blade.php`

## File Structure

```
Axis-Laravel/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/
│   │   │   ├── Admin/
│   │   │   └── [Frontend Controllers]
│   │   └── Middleware/
│   └── Models/
├── database/
│   └── migrations/
├── public/
│   └── assets/
├── resources/
│   └── views/
│       ├── layouts/
│       ├── frontend/
│       ├── admin/
│       └── auth/
├── routes/
├── .env
└── README.md
```

## Troubleshooting

### Database Connection Error
- Check `.env` file has correct database credentials
- Ensure MySQL is running
- Verify the database exists

### Storage Link Issues
If images aren't displaying:
```bash
php artisan storage:link
```

### Permission Issues
If you get permission errors:
```bash
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
```

### Static Files Not Loading
- Clear cache: `php artisan config:clear`
- Clear view cache: `php artisan view:clear`

## Security Notes

- Always use strong passwords
- Change the APP_KEY in .env before deployment
- Use environment variables for sensitive data
- Implement HTTPS in production
- Use CSRF tokens (already included in forms)
- Validate all user inputs

## Performance Optimization

### Caching
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Database Optimization
- Add indexes to frequently queried columns
- Use pagination for large datasets
- Consider eager loading relationships

## Additional Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Blade Template Documentation](https://laravel.com/docs/blade)
- [Eloquent ORM](https://laravel.com/docs/eloquent)

## Support

For issues or questions, review the Laravel documentation or check the code comments throughout the application.

## License

This project is provided as-is for your use.

---

**Last Updated:** February 10, 2026
