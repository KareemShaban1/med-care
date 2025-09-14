### 🛠 Developer Documentation

This project follows clean architecture principles with the Repository Pattern, making it modular, testable, and easy to extend.

### Project Structure

```
app/
├── Http/                # HTTP Controllers and Middleware
│   ├── Controllers/     # Application controllers
│   └── Requests/        # Request classes
├── Models/              # Eloquent models
├── Observers/           # Model observers
├── Policies/            # Authorization policies
├── Providers/           # Service providers
├── Repository/          # Data access layer
└── Traits/              # Reusable traits
├── View/                # View components

config/                 # Configuration files
database/
├── migrations/         # Database migrations
├── seeders/            # Database seeders
└── factories/          # Model factories

resources/
├── lang/               # Language files
├── views/              # Blade templates
│   ├── backend/        # Admin panel views
│   └── frontend/       # Frontend views
└── js/                 # JavaScript files

routes/                 # Application routes
storage/                # Storage for logs, cache, etc.
tests/                  # Test files
```

### Key Components

#### 1. Repository Pattern

The application uses the Repository pattern to abstract data access:

- **Location**: `app/Repository/`
- **Key Repositories**:
  - `OrderRepository`: Handles all order-related database operations
  - `ProductRepository`: Manages product data and business logic
  - `CategoryRepository`: Handles category operations
  - `BannerRepository`: Handles banner operations

  - `CartRepository`: Handles cart operations
  - `CheckoutRepository`: Handles checkout operations
  - `HomeRepository`: Handles frontend home operations

Example usage:
```php
// In a repository
class CartRepository implements CartRepositoryInterface
{
    protected function getCart(): array
    {
        return session()->get('cart', []);
    }

    public function add($request, $id)
    {
        $cart = $this->getCart();
        $cart[$id] = [
            'quantity' => $request->input('quantity', 1),
        ];

        session()->put('cart', $cart);

        return [
            'success' => true,
            'message' => 'Product added to cart successfully!',
        ];
    }
}


// In a repository interface
interface CartRepositoryInterface
{
    public function add($request, $id);
}

// In a controller
class CartController extends Controller
{
    protected CartRepositoryInterface $cartRepo;

    public function __construct(CartRepositoryInterface $cartRepo)
    {
        $this->cartRepo = $cartRepo;
    }

    public function add(Request $request, $id)
    {
        $response = $this->cartRepo->add($request, $id);

        return redirect()->back()->with(
            $response['success'] ? 'toast_success' : 'toast_error',
            $response['message']
        );
    }
}


```

#### 2. Model Observers

- **Location**: `app/Observers/`
- **Purpose**: Handle model events and business logic
- **Key Observers**:
  - `ProductObserver`: Tracks product changes and updates related models
  - `CategoryObserver`: Manages category hierarchy and relationships
  - `OrderObserver`: Manages order hierarchy and relationships
  - `GenericObserver`: Handles common model events


### Extending the Application
🚀 How to Extend
Adding a New Repository
```php
// 1- Create a new repository interface in `app/Repository/Interfaces/`
namespace App\Interfaces;
interface WishlistRepositoryInterface {
    public function add($request, $id);
    public function remove($id);
}

// 2- Create a new repository in `app/Repository/`
class WishlistRepository implements WishlistRepositoryInterface {
    public function add($request, $id) {
        // implementation
    }
    public function remove($id) {
        // implementation
    }
}

// 3- Register the repository in `app/Providers/AppServiceProvider.php`
protected $repositories = [
    WishlistRepositoryInterface::class => WishlistRepository::class,
];

// 4- Use the repository in your controller
public function __construct(WishlistRepositoryInterface $wishlistRepo)
{
    $this->wishlistRepo = $wishlistRepo;
}

```

### Testing

Run tests using:
```bash
# Run all tests
php artisan test

# Run specific test
php artisan test tests/Feature/ExampleTest.php
```

### Deployment

For production deployment:

1. Set `APP_ENV=production` in `.env`
2. Generate optimized autoload files:
   ```bash
   composer install --optimize-autoloader --no-dev
   ```
3. Cache configuration and routes:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```
4. Set up queue workers for background jobs (not exist yet in this project)
5. Configure proper file permissions

### Troubleshooting

Common issues and solutions:

1. **Storage link not working**:
   ```bash
   php artisan storage:link
   ```

2. **Cache issues**:
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan view:clear
   ```

3. **Database migrations**:
   ```bash
   php artisan migrate:fresh --seed
   ```

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.


