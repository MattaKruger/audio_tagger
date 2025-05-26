# Python to PHP Developer Transition Guide

A comprehensive guide for experienced Python developers transitioning to modern PHP (8.0+).

## Table of Contents
1. [Fundamental Differences](#fundamental-differences)
2. [Syntax Comparison](#syntax-comparison)
3. [Type System](#type-system)
4. [Object-Oriented Programming](#object-oriented-programming)
5. [Error Handling](#error-handling)
6. [Package Management & Ecosystem](#package-management--ecosystem)
7. [Web Development](#web-development)
8. [Testing](#testing)
9. [Performance & Best Practices](#performance--best-practices)
10. [Modern PHP Features](#modern-php-features)

## Fundamental Differences

### Runtime Model
- **Python**: Interpreted, runs continuously in web contexts
- **PHP**: Request-based, script executes per HTTP request then dies
- **Impact**: No shared state between requests, different memory management patterns

### Variable Declaration
```python
# Python - no declaration needed
name = "John"
age = 30
```

```php
<?php
// PHP - variables start with $
$name = "John";
$age = 30;
```

### Array Handling
```python
# Python - Lists and Dictionaries
fruits = ["apple", "banana", "cherry"]
person = {"name": "John", "age": 30}
```

```php
<?php
// PHP - Arrays serve both purposes
$fruits = ["apple", "banana", "cherry"];
$person = ["name" => "John", "age" => 30];

// Or explicit indexing
$fruits = [0 => "apple", 1 => "banana", 2 => "cherry"];
```

## Syntax Comparison

### Variables and Constants
```python
# Python
name = "John"
AGE = 30  # Convention for constants
```

```php
<?php
// PHP
$name = "John";
const AGE = 30;  // True constant
define('OLD_STYLE_CONSTANT', 30);  // Legacy way
```

### String Operations
```python
# Python
name = "John"
greeting = f"Hello, {name}!"
multiline = """
This is a
multiline string
"""
```

```php
<?php
// PHP
$name = "John";
$greeting = "Hello, {$name}!";  // Double quotes for interpolation
$greeting2 = "Hello, $name!";   // Simpler form
$multiline = "
This is a
multiline string
";

// Heredoc (like Python's triple quotes)
$multiline = <<<EOD
This is a
multiline string
EOD;
```

### Control Structures
```python
# Python
if age >= 18:
    print("Adult")
elif age >= 13:
    print("Teen")
else:
    print("Child")

for item in items:
    print(item)

while condition:
    do_something()
```

```php
<?php
// PHP
if ($age >= 18) {
    echo "Adult";
} elseif ($age >= 13) {
    echo "Teen";
} else {
    echo "Child";
}

foreach ($items as $item) {
    echo $item;
}

while ($condition) {
    doSomething();
}
```

### Functions
```python
# Python
def greet(name, age=25):
    return f"Hello {name}, you are {age}"

def process_user(name: str, age: int = 25) -> str:
    return f"Processing {name}"
```

```php
<?php
// PHP
function greet($name, $age = 25) {
    return "Hello $name, you are $age";
}

// Modern PHP with types
function processUser(string $name, int $age = 25): string {
    return "Processing $name";
}
```

## Type System

### Python vs PHP Type Hints
```python
# Python (3.5+)
from typing import List, Dict, Optional, Union

def process_data(
    items: List[str],
    config: Dict[str, int],
    optional_param: Optional[str] = None
) -> Union[str, None]:
    pass
```

```php
<?php
// PHP 8.0+
function processData(
    array $items,              // Array of strings (not enforced at runtime)
    array $config,             // Associative array
    ?string $optionalParam = null  // Nullable string
): ?string {
    return null;
}

// PHP 8.0+ Union Types
function flexibleReturn(bool $flag): string|int|null {
    return $flag ? "string" : 42;
}
```

### Strict Typing
```python
# Python - gradual typing, runtime checks optional
```

```php
<?php
declare(strict_types=1);  // Enable strict type checking

function addNumbers(int $a, int $b): int {
    return $a + $b;
}

// This will throw TypeError in strict mode
// addNumbers("5", "10");  // Error!
```

## Object-Oriented Programming

### Class Definition
```python
# Python
class User:
    def __init__(self, name: str, email: str):
        self.name = name
        self.email = email
        self._private_field = "private"

    def get_info(self) -> str:
        return f"{self.name} ({self.email})"

    @property
    def display_name(self) -> str:
        return self.name.title()

    @classmethod
    def from_dict(cls, data: dict):
        return cls(data['name'], data['email'])
```

```php
<?php
// PHP 8.0+
class User {
    public function __construct(
        public readonly string $name,      // Auto-creates property
        public readonly string $email,
        private string $privateField = "private"
    ) {}

    public function getInfo(): string {
        return "{$this->name} ({$this->email})";
    }

    public function getDisplayName(): string {
        return ucwords($this->name);
    }

    public static function fromArray(array $data): self {
        return new self($data['name'], $data['email']);
    }
}
```

### Inheritance and Interfaces
```python
# Python
from abc import ABC, abstractmethod

class Animal(ABC):
    @abstractmethod
    def make_sound(self) -> str:
        pass

class Dog(Animal):
    def make_sound(self) -> str:
        return "Woof!"
```

```php
<?php
// PHP
interface AnimalInterface {
    public function makeSound(): string;
}

abstract class Animal {
    abstract public function makeSound(): string;

    public function sleep(): string {
        return "Sleeping...";
    }
}

class Dog extends Animal implements AnimalInterface {
    public function makeSound(): string {
        return "Woof!";
    }
}
```

### Modern PHP OOP Features
```php
<?php
// Readonly classes (PHP 8.2+)
readonly class ImmutableUser {
    public function __construct(
        public string $name,
        public string $email,
    ) {}
}

// Enums (PHP 8.1+)
enum Status: string {
    case PENDING = 'pending';
    case COMPLETED = 'completed';
    case FAILED = 'failed';
}

// Match expression (PHP 8.0+)
$message = match($status) {
    Status::PENDING => 'Task is pending',
    Status::COMPLETED => 'Task completed',
    Status::FAILED => 'Task failed',
};
```

## Error Handling

### Exceptions
```python
# Python
class CustomError(Exception):
    pass

try:
    risky_operation()
except ValueError as e:
    print(f"Value error: {e}")
except CustomError as e:
    print(f"Custom error: {e}")
finally:
    cleanup()
```

```php
<?php
// PHP
class CustomException extends Exception {}

try {
    riskyOperation();
} catch (ValueError $e) {
    echo "Value error: " . $e->getMessage();
} catch (CustomException $e) {
    echo "Custom error: " . $e->getMessage();
} finally {
    cleanup();
}
```

### Error vs Exception Handling
```php
<?php
// PHP has both errors and exceptions
// Convert errors to exceptions for consistent handling
set_error_handler(function($severity, $message, $file, $line) {
    throw new ErrorException($message, 0, $severity, $file, $line);
});

// Result types for better error handling (similar to Rust)
class Result {
    public static function ok($value): self {
        return new self($value, null);
    }

    public static function error(string $error): self {
        return new self(null, $error);
    }

    private function __construct(
        private readonly mixed $value,
        private readonly ?string $error
    ) {}

    public function isOk(): bool {
        return $this->error === null;
    }

    public function getValue(): mixed {
        if ($this->error !== null) {
            throw new RuntimeException($this->error);
        }
        return $this->value;
    }
}
```

## Package Management & Ecosystem

### Python pip vs PHP Composer
```python
# Python - requirements.txt
requests==2.28.1
django==4.1.0
pytest==7.1.3
```

```json
// PHP - composer.json
{
    "require": {
        "guzzlehttp/guzzle": "^7.5",
        "symfony/console": "^6.0",
        "monolog/monolog": "^3.0"
    },
    "require-dev": {
        "phpunit/phpunit": "^10.0",
        "psalm/psalm": "^5.0"
    },
    "autoload": {
        "psr-4": {
            "App\\": "src/"
        }
    }
}
```

### Autoloading
```python
# Python - imports
from mypackage.module import MyClass
import json
```

```php
<?php
// PHP - Composer autoloader
require_once 'vendor/autoload.php';

use App\Service\UserService;
use GuzzleHttp\Client;

$userService = new UserService();
$httpClient = new Client();
```

### Popular PHP Packages
- **HTTP Client**: Guzzle (like Python's requests)
- **Testing**: PHPUnit (like pytest)
- **Logging**: Monolog (like Python's logging)
- **Database**: Doctrine ORM (like SQLAlchemy)
- **Validation**: Symfony Validator
- **CLI**: Symfony Console (like Click/argparse)

## Web Development

### Framework Comparison
```python
# Python Flask
from flask import Flask, request, jsonify

app = Flask(__name__)

@app.route('/users/<int:user_id>', methods=['GET'])
def get_user(user_id):
    user = User.find(user_id)
    return jsonify(user.to_dict())
```

```php
<?php
// PHP with Slim Framework (similar to Flask)
use Slim\Factory\AppFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app = AppFactory::create();

$app->get('/users/{id}', function (Request $request, Response $response, array $args) {
    $userId = (int) $args['id'];
    $user = User::find($userId);

    $response->getBody()->write(json_encode($user->toArray()));
    return $response->withHeader('Content-Type', 'application/json');
});
```

### Laravel (Like Django)
```php
<?php
// Laravel Controller
class UserController extends Controller {
    public function show(int $id): JsonResponse {
        $user = User::findOrFail($id);
        return response()->json($user);
    }
}

// Laravel Route
Route::get('/users/{id}', [UserController::class, 'show']);

// Laravel Model (Eloquent ORM)
class User extends Model {
    protected $fillable = ['name', 'email'];

    public function posts() {
        return $this->hasMany(Post::class);
    }
}
```

## Testing

### Testing Frameworks
```python
# Python - pytest
def test_user_creation():
    user = User("John", "john@example.com")
    assert user.name == "John"
    assert user.email == "john@example.com"

@pytest.fixture
def sample_user():
    return User("Test User", "test@example.com")
```

```php
<?php
// PHP - PHPUnit
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase {
    public function testUserCreation(): void {
        $user = new User("John", "john@example.com");
        $this->assertEquals("John", $user->name);
        $this->assertEquals("john@example.com", $user->email);
    }

    public function setUp(): void {
        $this->sampleUser = new User("Test User", "test@example.com");
    }
}
```

### Mocking and Test Doubles
```php
<?php
// PHPUnit mocking
class UserServiceTest extends TestCase {
    public function testGetUser(): void {
        $mockRepository = $this->createMock(UserRepositoryInterface::class);
        $mockRepository->method('findById')
                      ->with(1)
                      ->willReturn(new User("John", "john@example.com"));

        $userService = new UserService($mockRepository);
        $user = $userService->getUser(1);

        $this->assertEquals("John", $user->name);
    }
}
```

## Performance & Best Practices

### Memory Management
```python
# Python - Garbage collection handles most memory management
# Manual cleanup occasionally needed
del large_object
```

```php
<?php
// PHP - Request-based, memory freed after request
// Manual cleanup rarely needed, but available
unset($largeArray);

// Use generators for large datasets (like Python)
function readLargeFile(string $filename): Generator {
    $handle = fopen($filename, 'r');
    while (($line = fgets($handle)) !== false) {
        yield trim($line);
    }
    fclose($handle);
}
```

### Caching Strategies
```php
<?php
// APCu (in-memory cache between requests)
if (apcu_exists('user_' . $userId)) {
    $user = apcu_fetch('user_' . $userId);
} else {
    $user = User::find($userId);
    apcu_store('user_' . $userId, $user, 3600);
}

// Redis/Memcached integration
$redis = new Redis();
$redis->connect('127.0.0.1', 6379);
$cached = $redis->get('user_' . $userId);
```

## Modern PHP Features with Context

### PHP 8.0+ Features You Should Know

#### Union Types
**When to use**: APIs that accept multiple input formats, flexible function parameters
```php
<?php
// Use for flexible ID handling (common in REST APIs)
function processId(int|string $id): User {
    return User::find($id);  // Works with both "/users/123" and "/users/abc-uuid"
}

// Database connections that accept different config types
function connectDatabase(array|string $config): PDO {
    if (is_string($config)) {
        return new PDO($config);  // DSN string
    }
    return new PDO($config['dsn'], $config['user'], $config['pass']);  // Config array
}
```

#### Named Arguments
**When to use**: Functions with many optional parameters, improving code readability
```php
<?php
// Great for configuration objects and service constructors
$user = new User(
    name: "John Doe",
    email: "john@example.com",
    isActive: true,
    role: "admin"
);

// Especially useful for optional parameters in any order
$httpClient = new GuzzleClient(
    timeout: 30,
    verify: false,
    headers: ['User-Agent' => 'MyApp/1.0']
);

// Skip optional middle parameters
sendEmail(
    to: "user@example.com",
    subject: "Welcome!",
    template: "welcome",
    // Skip $cc, $bcc parameters
    priority: "high"
);
```

#### Match Expression
**When to use**: Replace complex switch statements, mapping values, status translations
```php
<?php
// Perfect for status mappings (common in business logic)
$statusMessage = match($orderStatus) {
    'pending' => 'Your order is being processed',
    'shipped' => 'Your order is on the way',
    'delivered' => 'Your order has arrived',
    'cancelled' => 'Your order was cancelled',
    default => throw new InvalidArgumentException("Unknown status: $orderStatus")
};

// HTTP status code handling
$response = match($httpCode) {
    200, 201, 202 => 'success',
    400, 422 => 'client_error',
    401, 403 => 'auth_error',
    500, 502, 503 => 'server_error',
    default => 'unknown_error'
};

// Better than switch for calculations
$shippingCost = match($shippingMethod) {
    'standard' => 5.99,
    'express' => 12.99,
    'overnight' => 24.99,
    'pickup' => 0.00,
};
```

#### Nullsafe Operator
**When to use**: Chaining operations on potentially null objects, avoiding nested null checks
```php
<?php
// Perfect for optional relationships in models
$country = $user?->profile?->address?->country ?? 'Unknown';

// API responses with optional nested data
$avatarUrl = $apiResponse?->user?->profile?->avatar?->url;

// Replace verbose null checking
// Old way:
if ($user !== null && $user->getProfile() !== null && $user->getProfile()->getAddress() !== null) {
    $country = $user->getProfile()->getAddress()->getCountry();
}

// New way:
$country = $user?->getProfile()?->getAddress()?->getCountry();
```

#### Constructor Property Promotion
**When to use**: Data classes, DTOs, value objects, simple services
```php
<?php
// Perfect for DTOs and value objects
readonly class Money {
    public function __construct(
        public int $amount,      // Amount in cents
        public string $currency,
    ) {}
}

// Services with simple dependencies
class UserService {
    public function __construct(
        private UserRepositoryInterface $userRepo,
        private EmailService $emailService,
        private LoggerInterface $logger,
    ) {}
}

// Configuration classes
class DatabaseConfig {
    public function __construct(
        public readonly string $host,
        public readonly int $port,
        public readonly string $database,
        public readonly string $username,
        private readonly string $password,  // Private for security
    ) {}
}
```

### PHP 8.1+ Additional Features

#### Enums
**When to use**: Fixed sets of values, status codes, configuration options, type safety
```php
<?php
// Perfect for status fields in databases
enum OrderStatus: string {
    case PENDING = 'pending';
    case CONFIRMED = 'confirmed';
    case SHIPPED = 'shipped';
    case DELIVERED = 'delivered';
    case CANCELLED = 'cancelled';

    // Add behavior to enums
    public function canBeModified(): bool {
        return match($this) {
            self::PENDING, self::CONFIRMED => true,
            default => false,
        };
    }

    public function getDisplayName(): string {
        return match($this) {
            self::PENDING => 'Awaiting Confirmation',
            self::CONFIRMED => 'Order Confirmed',
            self::SHIPPED => 'In Transit',
            self::DELIVERED => 'Delivered',
            self::CANCELLED => 'Cancelled',
        };
    }
}

// User roles and permissions
enum UserRole: string {
    case ADMIN = 'admin';
    case MODERATOR = 'moderator';
    case USER = 'user';
    case GUEST = 'guest';

    public function getPermissions(): array {
        return match($this) {
            self::ADMIN => ['read', 'write', 'delete', 'manage_users'],
            self::MODERATOR => ['read', 'write', 'moderate'],
            self::USER => ['read', 'write'],
            self::GUEST => ['read'],
        };
    }
}

// HTTP methods for API routing
enum HttpMethod: string {
    case GET = 'GET';
    case POST = 'POST';
    case PUT = 'PUT';
    case PATCH = 'PATCH';
    case DELETE = 'DELETE';
}
```

#### Readonly Properties
**When to use**: Immutable data, preventing accidental modification, thread-safe objects
```php
<?php
// Domain entities that shouldn't change after creation
class User {
    public function __construct(
        public readonly int $id,
        public readonly string $email,
        public string $name,           // Can be modified
        public readonly DateTime $createdAt,
    ) {}

    // Only provide methods that return new instances for "changes"
    public function withName(string $newName): self {
        return new self($this->id, $this->email, $newName, $this->createdAt);
    }
}

// Configuration objects that should never change at runtime
class ApiConfig {
    public function __construct(
        public readonly string $baseUrl,
        public readonly string $apiKey,
        public readonly int $timeout,
    ) {}
}

// Value objects in Domain-Driven Design
class Email {
    public function __construct(
        public readonly string $value,
    ) {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Invalid email format');
        }
    }
}
```

#### First-class Callable Syntax
**When to use**: Functional programming patterns, cleaner callback syntax
```php
<?php
// Cleaner array operations
$users = [
    new User('John', 'john@example.com'),
    new User('Jane', 'jane@example.com'),
];

// Old way
$names = array_map(fn($user) => $user->getName(), $users);

// New way (PHP 8.1+)
$names = array_map(User::getName(...), $users);

// Perfect for event handlers and middleware
class EventDispatcher {
    private array $listeners = [];

    public function listen(string $event, callable $listener): void {
        $this->listeners[$event][] = $listener;
    }
}

// Clean registration
$dispatcher->listen('user.created', UserNotificationService::sendWelcomeEmail(...));
$dispatcher->listen('order.completed', OrderService::sendConfirmation(...));

// Pipeline patterns
$result = collect($data)
    ->map(DataTransformer::normalize(...))
    ->filter(DataValidator::isValid(...))
    ->reduce(DataAggregator::sum(...));
```

### PHP 8.2+ Features

#### Readonly Classes
**When to use**: Immutable data structures, configuration objects, DTOs
```php
<?php
// Perfect for configuration that never changes
readonly class DatabaseConfiguration {
    public function __construct(
        public string $host,
        public int $port,
        public string $database,
        public string $username,
        public string $password,
    ) {}
}

// API response DTOs
readonly class ApiResponse {
    public function __construct(
        public int $statusCode,
        public array $data,
        public ?string $error = null,
    ) {}
}

// Event objects in event-driven architecture
readonly class UserRegisteredEvent {
    public function __construct(
        public int $userId,
        public string $email,
        public DateTime $occurredAt,
    ) {}
}

// Money objects for financial calculations
readonly class Money {
    public function __construct(
        public int $amount,
        public string $currency,
    ) {}

    public function add(Money $other): Money {
        if ($this->currency !== $other->currency) {
            throw new InvalidArgumentException('Currency mismatch');
        }
        return new Money($this->amount + $other->amount, $this->currency);
    }
}
```

#### Disjunctive Normal Form (DNF) Types
**When to use**: Complex type constraints, plugin systems, advanced OOP patterns
```php
<?php
// Plugin systems with multiple interfaces
interface Cacheable {
    public function getCacheKey(): string;
}

interface Serializable {
    public function serialize(): string;
}

interface Loggable {
    public function getLogData(): array;
}

// Objects must implement BOTH Cacheable AND Serializable, OR be null
function processData((Cacheable&Serializable)|null $data): void {
    if ($data === null) {
        return;
    }

    // We know $data implements both interfaces
    $cacheKey = $data->getCacheKey();
    $serialized = $data->serialize();
    // ... cache the serialized data
}

// Advanced repository patterns
interface ReadableRepository {
    public function find(int $id): ?Entity;
}

interface WritableRepository {
    public function save(Entity $entity): void;
}

// Repository must be both readable and writable, OR a read-only cache
function syncData((ReadableRepository&WritableRepository)|CacheRepository $repo): void {
    // Type system ensures we have the right capabilities
}
```

### When NOT to Use These Features

#### Avoid Union Types When:
- Types are truly unrelated (prefer separate methods)
- You need different behavior per type (use polymorphism instead)

#### Avoid Named Arguments When:
- Function has only 1-2 parameters
- Parameter order is logical and unlikely to change
- Performance is critical (slight overhead)

#### Avoid Match When:
- Simple if/else is clearer
- You need to execute multiple statements per case

#### Avoid Readonly When:
- Objects need to be modified after creation
- Working with frameworks that require mutable objects
- Debugging is difficult (harder to inspect/modify state)

## Design Patterns

Design patterns are crucial in PHP development, especially when building scalable applications. Let's explore common patterns using a TodoApp as our example.

### Repository Pattern

The Repository pattern provides an abstraction layer between your business logic and data access.

**Python equivalent using ABC (Abstract Base Class):**
```python
from abc import ABC, abstractmethod
from typing import List, Optional

class TodoRepository(ABC):
    @abstractmethod
    def find_all(self) -> List['Todo']:
        pass

    @abstractmethod
    def find_by_id(self, todo_id: int) -> Optional['Todo']:
        pass

    @abstractmethod
    def save(self, todo: 'Todo') -> 'Todo':
        pass

    @abstractmethod
    def delete(self, todo_id: int) -> bool:
        pass

class DatabaseTodoRepository(TodoRepository):
    def __init__(self, db_connection):
        self.db = db_connection

    def find_all(self) -> List['Todo']:
        cursor = self.db.execute("SELECT * FROM todos ORDER BY created_at DESC")
        return [Todo.from_dict(row) for row in cursor.fetchall()]
```

**PHP Implementation:**
```php
interface TodoRepositoryInterface
{
    public function findAll(): array;
    public function findById(int $id): ?Todo;
    public function save(Todo $todo): Todo;
    public function delete(int $id): bool;
}

class DatabaseTodoRepository implements TodoRepositoryInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM todos ORDER BY created_at DESC");
        return array_map(fn($row) => Todo::fromArray($row), $stmt->fetchAll());
    }

    public function findById(int $id): ?Todo
    {
        $stmt = $this->pdo->prepare("SELECT * FROM todos WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();

        return $row ? Todo::fromArray($row) : null;
    }

    public function save(Todo $todo): Todo
    {
        if ($todo->getId()) {
            return $this->update($todo);
        }
        return $this->create($todo);
    }

    private function create(Todo $todo): Todo
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO todos (title, description, completed) VALUES (?, ?, ?)"
        );
        $stmt->execute([$todo->getTitle(), $todo->getDescription(), $todo->isCompleted()]);

        return $todo->withId($this->pdo->lastInsertId());
    }

    private function update(Todo $todo): Todo
    {
        $stmt = $this->pdo->prepare(
            "UPDATE todos SET title = ?, description = ?, completed = ? WHERE id = ?"
        );
        $stmt->execute([
            $todo->getTitle(),
            $todo->getDescription(),
            $todo->isCompleted(),
            $todo->getId()
        ]);

        return $todo;
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM todos WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
```

### Service Layer Pattern

Services contain business logic and coordinate between controllers and repositories.

**Python equivalent:**
```python
class TodoService:
    def __init__(self, repository: TodoRepository, event_dispatcher):
        self.repository = repository
        self.event_dispatcher = event_dispatcher

    def create_todo(self, title: str, description: str = '') -> 'Todo':
        todo = Todo(title=title, description=description, completed=False)
        saved_todo = self.repository.save(todo)
        self.event_dispatcher.dispatch(TodoCreatedEvent(saved_todo))
        return saved_todo

    def complete_todo(self, todo_id: int) -> 'Todo':
        todo = self.repository.find_by_id(todo_id)
        if not todo:
            raise TodoNotFoundException(f"Todo with ID {todo_id} not found")

        if todo.completed:
            raise TodoAlreadyCompletedException("Todo is already completed")

        todo.completed = True  # Or use immutable approach
        saved_todo = self.repository.save(todo)
        self.event_dispatcher.dispatch(TodoCompletedEvent(saved_todo))
        return saved_todo
```

**PHP Implementation:**
```php
class TodoService
{
    private TodoRepositoryInterface $repository;
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(
        TodoRepositoryInterface $repository,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->repository = $repository;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function createTodo(string $title, string $description = ''): Todo
    {
        $todo = new Todo(
            id: null,
            title: $title,
            description: $description,
            completed: false
        );

        $savedTodo = $this->repository->save($todo);

        $this->eventDispatcher->dispatch(new TodoCreatedEvent($savedTodo));

        return $savedTodo;
    }

    public function completeTodo(int $id): Todo
    {
        $todo = $this->repository->findById($id);

        if (!$todo) {
            throw new TodoNotFoundException("Todo with ID {$id} not found");
        }

        if ($todo->isCompleted()) {
            throw new TodoAlreadyCompletedException("Todo is already completed");
        }

        $completedTodo = $todo->markAsCompleted();
        $savedTodo = $this->repository->save($completedTodo);

        $this->eventDispatcher->dispatch(new TodoCompletedEvent($savedTodo));

        return $savedTodo;
    }

    public function getAllTodos(): array
    {
        return $this->repository->findAll();
    }

    public function getActiveTodos(): array
    {
        return array_filter(
            $this->repository->findAll(),
            fn(Todo $todo) => !$todo->isCompleted()
        );
    }
}
```

### Factory Pattern

Factories help create complex objects or handle object creation logic.

**Python equivalent:**
```python
import html
from typing import Dict, Any

class TodoFactory:
    @staticmethod
    def create_from_request(data: Dict[str, Any]) -> 'Todo':
        return Todo(
            id=data.get('id'),
            title=TodoFactory._sanitize_title(data.get('title', '')),
            description=TodoFactory._sanitize_description(data.get('description', '')),
            completed=bool(data.get('completed', False))
        )

    @staticmethod
    def create_quick_todo(title: str) -> 'Todo':
        return Todo(
            title=TodoFactory._sanitize_title(title),
            description='',
            completed=False
        )

    @staticmethod
    def _sanitize_title(title: str) -> str:
        title = title.strip()
        if not title:
            raise ValueError('Todo title cannot be empty')
        return html.escape(title)
```

**PHP Implementation:**
```php
class TodoFactory
{
    public static function createFromRequest(array $data): Todo
    {
        return new Todo(
            id: $data['id'] ?? null,
            title: self::sanitizeTitle($data['title'] ?? ''),
            description: self::sanitizeDescription($data['description'] ?? ''),
            completed: (bool)($data['completed'] ?? false)
        );
    }

    public static function createQuickTodo(string $title): Todo
    {
        return new Todo(
            id: null,
            title: self::sanitizeTitle($title),
            description: '',
            completed: false
        );
    }

    private static function sanitizeTitle(string $title): string
    {
        $title = trim($title);
        if (empty($title)) {
            throw new InvalidArgumentException('Todo title cannot be empty');
        }
        return htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
    }

    private static function sanitizeDescription(string $description): string
    {
        return htmlspecialchars(trim($description), ENT_QUOTES, 'UTF-8');
    }
}

// Usage
$todo = TodoFactory::createFromRequest($_POST);
$quickTodo = TodoFactory::createQuickTodo('Buy groceries');
```

### Observer Pattern (Event System)

Modern PHP often uses event dispatchers instead of direct observer implementations.

**Python equivalent using built-in Observer pattern:**
```python
from abc import ABC, abstractmethod
from typing import List

# Traditional Observer Pattern
class Observer(ABC):
    @abstractmethod
    def update(self, event) -> None:
        pass

class TodoSubject:
    def __init__(self):
        self._observers: List[Observer] = []

    def attach(self, observer: Observer) -> None:
        self._observers.append(observer)

    def notify(self, event) -> None:
        for observer in self._observers:
            observer.update(event)

class EmailNotificationObserver(Observer):
    def update(self, event) -> None:
        if isinstance(event, TodoCreatedEvent):
            print(f"Email: New todo created: {event.todo.title}")

# Modern Event-driven approach (similar to Django signals)
from django.dispatch import Signal

todo_created = Signal()
todo_completed = Signal()

def send_email_notification(sender, **kwargs):
    todo = kwargs['todo']
    print(f"Email: Todo created: {todo.title}")

todo_created.connect(send_email_notification)
```

**PHP Implementation:**
```php
interface EventInterface
{
    public function getName(): string;
}

class TodoCreatedEvent implements EventInterface
{
    public function __construct(private Todo $todo) {}

    public function getName(): string
    {
        return 'todo.created';
    }

    public function getTodo(): Todo
    {
        return $this->todo;
    }
}

class TodoCompletedEvent implements EventInterface
{
    public function __construct(private Todo $todo) {}

    public function getName(): string
    {
        return 'todo.completed';
    }

    public function getTodo(): Todo
    {
        return $this->todo;
    }
}

interface EventListenerInterface
{
    public function handle(EventInterface $event): void;
}

class EmailNotificationListener implements EventListenerInterface
{
    public function handle(EventInterface $event): void
    {
        match ($event::class) {
            TodoCreatedEvent::class => $this->sendCreationEmail($event->getTodo()),
            TodoCompletedEvent::class => $this->sendCompletionEmail($event->getTodo()),
            default => null
        };
    }

    private function sendCreationEmail(Todo $todo): void
    {
        // Send email notification logic
        error_log("Email: New todo created: {$todo->getTitle()}");
    }

    private function sendCompletionEmail(Todo $todo): void
    {
        // Send completion email logic
        error_log("Email: Todo completed: {$todo->getTitle()}");
    }
}

class StatisticsListener implements EventListenerInterface
{
    public function handle(EventInterface $event): void
    {
        match ($event::class) {
            TodoCreatedEvent::class => $this->incrementCreatedCount(),
            TodoCompletedEvent::class => $this->incrementCompletedCount(),
            default => null
        };
    }

    private function incrementCreatedCount(): void
    {
        // Update statistics
        error_log("Stats: Todo created count incremented");
    }

    private function incrementCompletedCount(): void
    {
        // Update statistics
        error_log("Stats: Todo completed count incremented");
    }
}
```

### Dependency Injection Container

Modern PHP applications use DI containers for managing dependencies.

**Python equivalent using dependency-injector or simple DI:**
```python
from typing import Dict, Callable, Any

class Container:
    def __init__(self):
        self._services: Dict[str, Any] = {}
        self._factories: Dict[str, Callable] = {}

    def register(self, key: str, factory: Callable) -> None:
        self._factories[key] = factory

    def set(self, key: str, instance: Any) -> None:
        self._services[key] = instance

    def get(self, key: str) -> Any:
        if key in self._services:
            return self._services[key]

        if key in self._factories:
            instance = self._factories[key](self)
            self._services[key] = instance
            return instance

        raise ValueError(f"Service {key} not found")

# Setup
container = Container()
container.register('database', lambda c: create_database_connection())
container.register('todo_repository', lambda c: DatabaseTodoRepository(c.get('database')))
container.register('todo_service', lambda c: TodoService(c.get('todo_repository')))
```

**PHP Implementation:**
```php
interface ContainerInterface
{
    public function get(string $id): mixed;
    public function has(string $id): bool;
    public function set(string $id, mixed $value): void;
}

class Container implements ContainerInterface
{
    private array $services = [];
    private array $factories = [];

    public function set(string $id, mixed $value): void
    {
        if (is_callable($value)) {
            $this->factories[$id] = $value;
        } else {
            $this->services[$id] = $value;
        }
    }

    public function get(string $id): mixed
    {
        if (isset($this->services[$id])) {
            return $this->services[$id];
        }

        if (isset($this->factories[$id])) {
            $this->services[$id] = $this->factories[$id]($this);
            return $this->services[$id];
        }

        throw new RuntimeException("Service {$id} not found");
    }

    public function has(string $id): bool
    {
        return isset($this->services[$id]) || isset($this->factories[$id]);
    }
}

// Container setup
$container = new Container();

$container->set(PDO::class, function() {
    return new PDO('sqlite::memory:');
});

$container->set(TodoRepositoryInterface::class, function(Container $c) {
    return new DatabaseTodoRepository($c->get(PDO::class));
});

$container->set(EventDispatcherInterface::class, function() {
    $dispatcher = new EventDispatcher();
    $dispatcher->addListener(new EmailNotificationListener());
    $dispatcher->addListener(new StatisticsListener());
    return $dispatcher;
});

$container->set(TodoService::class, function(Container $c) {
    return new TodoService(
        $c->get(TodoRepositoryInterface::class),
        $c->get(EventDispatcherInterface::class)
    );
});
```

### Strategy Pattern

Use strategy pattern for different todo sorting or filtering approaches.

**Python equivalent:**
```python
from abc import ABC, abstractmethod
from typing import List
from datetime import datetime

class TodoSortStrategy(ABC):
    @abstractmethod
    def sort(self, todos: List['Todo']) -> List['Todo']:
        pass

class DateSortStrategy(TodoSortStrategy):
    def __init__(self, ascending: bool = True):
        self.ascending = ascending

    def sort(self, todos: List['Todo']) -> List['Todo']:
        return sorted(
            todos,
            key=lambda todo: todo.created_at,
            reverse=not self.ascending
        )

class PrioritySortStrategy(TodoSortStrategy):
    def sort(self, todos: List['Todo']) -> List['Todo']:
        return sorted(
            todos,
            key=lambda todo: (todo.completed, -todo.priority)
        )

class TodoSorter:
    def __init__(self, strategy: TodoSortStrategy):
        self.strategy = strategy

    def set_strategy(self, strategy: TodoSortStrategy) -> None:
        self.strategy = strategy

    def sort(self, todos: List['Todo']) -> List['Todo']:
        return self.strategy.sort(todos)
```

**PHP Implementation:**
```php
interface TodoSortStrategyInterface
{
    public function sort(array $todos): array;
}

class DateSortStrategy implements TodoSortStrategyInterface
{
    public function __construct(private bool $ascending = true) {}

    public function sort(array $todos): array
    {
        usort($todos, function(Todo $a, Todo $b) {
            $result = $a->getCreatedAt() <=> $b->getCreatedAt();
            return $this->ascending ? $result : -$result;
        });

        return $todos;
    }
}

class PrioritySortStrategy implements TodoSortStrategyInterface
{
    public function sort(array $todos): array
    {
        // Sort by completion status first, then by priority
        usort($todos, function(Todo $a, Todo $b) {
            if ($a->isCompleted() !== $b->isCompleted()) {
                return $a->isCompleted() ? 1 : -1;
            }
            return $b->getPriority() <=> $a->getPriority();
        });

        return $todos;
    }
}

class TodoSorter
{
    public function __construct(private TodoSortStrategyInterface $strategy) {}

    public function setStrategy(TodoSortStrategyInterface $strategy): void
    {
        $this->strategy = $strategy;
    }

    public function sort(array $todos): array
    {
        return $this->strategy->sort($todos);
    }
}

// Usage
$sorter = new TodoSorter(new DateSortStrategy());
$sortedTodos = $sorter->sort($todos);

$sorter->setStrategy(new PrioritySortStrategy());
$prioritySorted = $sorter->sort($todos);
```

### Command Pattern

Useful for undo/redo functionality or queuing operations.

**Python equivalent:**
```python
from abc import ABC, abstractmethod
from typing import Any, Optional, List

class Command(ABC):
    @abstractmethod
    def execute(self) -> Any:
        pass

    @abstractmethod
    def undo(self) -> None:
        pass

class CreateTodoCommand(Command):
    def __init__(self, service: 'TodoService', title: str, description: str = ''):
        self.service = service
        self.title = title
        self.description = description
        self.created_todo: Optional['Todo'] = None

    def execute(self) -> 'Todo':
        self.created_todo = self.service.create_todo(self.title, self.description)
        return self.created_todo

    def undo(self) -> None:
        if self.created_todo:
            self.service.delete_todo(self.created_todo.id)

class CommandInvoker:
    def __init__(self):
        self.history: List[Command] = []
        self.current_position = -1

    def execute(self, command: Command) -> Any:
        result = command.execute()
        self.history = self.history[:self.current_position + 1]
        self.history.append(command)
        self.current_position += 1
        return result

    def undo(self) -> bool:
        if self.current_position >= 0:
            command = self.history[self.current_position]
            command.undo()
            self.current_position -= 1
            return True
        return False
```

**PHP Implementation:**
```php
interface CommandInterface
{
    public function execute(): mixed;
    public function undo(): void;
}

class CreateTodoCommand implements CommandInterface
{
    private ?Todo $createdTodo = null;

    public function __construct(
        private TodoService $service,
        private string $title,
        private string $description = ''
    ) {}

    public function execute(): Todo
    {
        $this->createdTodo = $this->service->createTodo($this->title, $this->description);
        return $this->createdTodo;
    }

    public function undo(): void
    {
        if ($this->createdTodo) {
            $this->service->deleteTodo($this->createdTodo->getId());
        }
    }
}

class CompleteTodoCommand implements CommandInterface
{
    private ?Todo $originalTodo = null;

    public function __construct(
        private TodoService $service,
        private int $todoId
    ) {}

    public function execute(): Todo
    {
        $this->originalTodo = $this->service->getTodoById($this->todoId);
        return $this->service->completeTodo($this->todoId);
    }

    public function undo(): void
    {
        if ($this->originalTodo) {
            $this->service->updateTodo(
                $this->originalTodo->getId(),
                $this->originalTodo->getTitle(),
                $this->originalTodo->getDescription(),
                false
            );
        }
    }
}

class CommandInvoker
{
    private array $history = [];
    private int $currentPosition = -1;

    public function execute(CommandInterface $command): mixed
    {
        $result = $command->execute();

        // Remove any commands after current position (for redo scenarios)
        $this->history = array_slice($this->history, 0, $this->currentPosition + 1);

        $this->history[] = $command;
        $this->currentPosition++;

        return $result;
    }

    public function undo(): bool
    {
        if ($this->currentPosition >= 0) {
            $command = $this->history[$this->currentPosition];
            $command->undo();
            $this->currentPosition--;
            return true;
        }

        return false;
    }

    public function redo(): bool
    {
        if ($this->currentPosition < count($this->history) - 1) {
            $this->currentPosition++;
            $command = $this->history[$this->currentPosition];
            $command->execute();
            return true;
        }

        return false;
    }
}

// Usage
$invoker = new CommandInvoker();
$todoService = $container->get(TodoService::class);

$createCommand = new CreateTodoCommand($todoService, 'Learn PHP patterns');
$todo = $invoker->execute($createCommand);

$completeCommand = new CompleteTodoCommand($todoService, $todo->getId());
$invoker->execute($completeCommand);

// Undo the completion
$invoker->undo();

// Undo the creation
$invoker->undo();
```

### Complete Todo Entity

Here's the complete Todo entity that supports all our patterns:

**Python equivalent using dataclass (Python 3.7+):**
```python
from dataclasses import dataclass, replace
from datetime import datetime
from typing import Optional, Dict, Any

@dataclass(frozen=True)  # Immutable like PHP readonly
class Todo:
    title: str
    description: str
    completed: bool
    id: Optional[int] = None
    priority: int = 1
    created_at: datetime = None
    completed_at: Optional[datetime] = None

    def __post_init__(self):
        if self.created_at is None:
            object.__setattr__(self, 'created_at', datetime.now())

    def with_id(self, todo_id: int) -> 'Todo':
        return replace(self, id=todo_id)

    def mark_as_completed(self) -> 'Todo':
        return replace(self, completed=True, completed_at=datetime.now())

    def update_title(self, title: str) -> 'Todo':
        return replace(self, title=title)

    @classmethod
    def from_dict(cls, data: Dict[str, Any]) -> 'Todo':
        return cls(
            id=data.get('id'),
            title=data['title'],
            description=data.get('description', ''),
            completed=bool(data.get('completed', False)),
            priority=data.get('priority', 1),
            created_at=datetime.fromisoformat(data['created_at']) if data.get('created_at') else None,
            completed_at=datetime.fromisoformat(data['completed_at']) if data.get('completed_at') else None
        )
```

**PHP Implementation:**
```php
readonly class Todo
{
    public function __construct(
        private ?int $id,
        private string $title,
        private string $description,
        private bool $completed,
        private int $priority = 1,
        private DateTimeImmutable $createdAt = new DateTimeImmutable(),
        private ?DateTimeImmutable $completedAt = null
    ) {}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function isCompleted(): bool
    {
        return $this->completed;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getCompletedAt(): ?DateTimeImmutable
    {
        return $this->completedAt;
    }

    public function withId(int $id): self
    {
        return new self(
            $id,
            $this->title,
            $this->description,
            $this->completed,
            $this->priority,
            $this->createdAt,
            $this->completedAt
        );
    }

    public function markAsCompleted(): self
    {
        return new self(
            $this->id,
            $this->title,
            $this->description,
            true,
            $this->priority,
            $this->createdAt,
            new DateTimeImmutable()
        );
    }

    public function updateTitle(string $title): self
    {
        return new self(
            $this->id,
            $title,
            $this->description,
            $this->completed,
            $this->priority,
            $this->createdAt,
            $this->completedAt
        );
    }

    public function updatePriority(int $priority): self
    {
        return new self(
            $this->id,
            $this->title,
            $this->description,
            $this->completed,
            $priority,
            $this->createdAt,
            $this->completedAt
        );
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            title: $data['title'],
            description: $data['description'] ?? '',
            completed: (bool)($data['completed'] ?? false),
            priority: $data['priority'] ?? 1,
            createdAt: isset($data['created_at'])
                ? new DateTimeImmutable($data['created_at'])
                : new DateTimeImmutable(),
            completedAt: isset($data['completed_at'])
                ? new DateTimeImmutable($data['completed_at'])
                : null
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'completed' => $this->completed,
            'priority' => $this->priority,
            'created_at' => $this->createdAt->format('Y-m-d H:i:s'),
            'completed_at' => $this->completedAt?->format('Y-m-d H:i:s'),
        ];
    }
}
```

### Pattern Usage Summary

These patterns work together in a typical PHP application:

1. **Repository** handles data access
2. **Service Layer** contains business logic
3. **Factory** creates objects consistently
4. **Observer/Events** handle side effects
5. **DI Container** manages dependencies
6. **Strategy** provides algorithm variations
7. **Command** enables undo/redo and queuing

**Key Python vs PHP Pattern Differences:**

| Pattern | Python Approach | PHP Approach |
|---------|----------------|--------------|
| **Repository** | ABC with type hints | Interfaces with return types |
| **DI Container** | Dictionary-based or libs like `dependency-injector` | Built into frameworks (Symfony, Laravel) |
| **Events** | Django signals, custom observers | Event dispatchers, PSR-14 |
| **Immutability** | `@dataclass(frozen=True)`, `replace()` | `readonly` classes, `with*()` methods |
| **Type System** | Optional type hints | Strict types available |
| **Naming** | snake_case methods | camelCase methods |

This architecture provides maintainable, testable, and scalable code that's common in modern PHP applications like Laravel, Symfony, and other frameworks.

## Key Differences to Remember

### 1. Variable Scope
- Python: LEGB rule (Local, Enclosing, Global, Built-in)
- PHP: Function-scoped, need `global` keyword or `$GLOBALS`

### 2. Array Behavior
- Python: Lists and dicts are different types
- PHP: Arrays are ordered maps, serve both purposes

### 3. String Handling
- Python: Immutable strings
- PHP: Mutable strings, different quote behavior

### 4. Import System
- Python: Module-based imports
- PHP: Namespace-based autoloading via Composer

### 5. Execution Model
- Python: Long-running processes
- PHP: Request-response cycle (traditionally)

## Learning Resources

### Official Documentation
- [PHP.net Manual](https://www.php.net/manual/en/)
- [Modern PHP Features](https://php.watch/)

### Best Practices
- [PHP Standards Recommendations (PSR)](https://www.php-fig.org/psr/)
- [PHP The Right Way](https://phptherightway.com/)

### Tools
- **IDE**: PhpStorm, VS Code with PHP extensions
- **Static Analysis**: Psalm, PHPStan
- **Code Style**: PHP-CS-Fixer, PHPCS
- **Debugging**: Xdebug

## Quick Start Checklist

1. **Set up PHP 8.1+** with Composer
2. **Learn PSR standards** (especially PSR-4 autoloading, PSR-12 coding style)
3. **Practice with a framework** (Laravel for full-stack, Slim for APIs)
4. **Set up proper tooling** (IDE, linter, debugger)
5. **Write tests** with PHPUnit
6. **Understand the ecosystem** (Packagist, major packages)
7. **Learn deployment patterns** (PHP-FPM, containers, serverless)

The transition from Python to PHP should feel natural given your programming background. Focus on understanding the request-response model and embracing PHP's modern features while leveraging your existing OOP and web development knowledge.
